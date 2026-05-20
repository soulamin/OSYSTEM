<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        $clientId = (int) ($user?->client_id ?? 0);
        $userId = (int) ($user?->id ?? 0);

        $base = Order::query();
        if ($role === 'cliente' && $clientId > 0) {
            $base->where('client_id', $clientId);
        }
        if ($role === 'tecnico' && $userId > 0) {
            $base->where('responsible_user_id', $userId);
        }

        $open = (clone $base)->where('status', Order::STATUS_ABERTA)->count();
        $finalized = (clone $base)->where('status', Order::STATUS_FINALIZADA)->count();
        $revenueTotal = (clone $base)->where('status', Order::STATUS_FINALIZADA)->sum('total_value');

        $chart = null;
        if ($role === 'admin') {
            $start = now()->startOfMonth()->subMonths(11);
            $end = now()->endOfMonth();

            $months = [];
            $monthIndex = [];
            for ($i = 0; $i < 12; $i++) {
                $m = (clone $start)->addMonths($i);
                $key = $m->format('Y-m');
                $months[] = $m->format('m/Y');
                $monthIndex[$key] = $i;
            }

            $categories = OrderCategory::query()->orderBy('name')->get(['id', 'name'])->map(function ($c) {
                return ['id' => (int) $c->id, 'name' => (string) $c->name];
            })->values()->all();
            array_unshift($categories, ['id' => 0, 'name' => 'Sem categoria']);

            $openCounts = [];
            $closedCounts = [];
            foreach ($categories as $c) {
                $openCounts[$c['id']] = array_fill(0, 12, 0);
                $closedCounts[$c['id']] = array_fill(0, 12, 0);
            }

            $openOrders = (clone $base)
                ->where('status', Order::STATUS_ABERTA)
                ->whereBetween('opened_at', [$start, $end])
                ->get(['category_id', 'opened_at']);

            foreach ($openOrders as $o) {
                $key = optional($o->opened_at)->format('Y-m');
                if (!isset($monthIndex[$key])) {
                    continue;
                }
                $cid = (int) ($o->category_id ?? 0);
                if (!array_key_exists($cid, $openCounts)) {
                    $openCounts[$cid] = array_fill(0, 12, 0);
                }
                $openCounts[$cid][$monthIndex[$key]]++;
            }

            $closedOrders = (clone $base)
                ->where('status', Order::STATUS_FINALIZADA)
                ->whereNotNull('closed_at')
                ->whereBetween('closed_at', [$start, $end])
                ->get(['category_id', 'closed_at']);

            foreach ($closedOrders as $o) {
                $key = optional($o->closed_at)->format('Y-m');
                if (!isset($monthIndex[$key])) {
                    continue;
                }
                $cid = (int) ($o->category_id ?? 0);
                if (!array_key_exists($cid, $closedCounts)) {
                    $closedCounts[$cid] = array_fill(0, 12, 0);
                }
                $closedCounts[$cid][$monthIndex[$key]]++;
            }

            $seriesOpen = [];
            $seriesClosed = [];

            foreach ($categories as $c) {
                $cid = $c['id'];
                $openData = $openCounts[$cid] ?? array_fill(0, 12, 0);
                $closedData = $closedCounts[$cid] ?? array_fill(0, 12, 0);
                $sum = array_sum($openData) + array_sum($closedData);
                if ($sum === 0) {
                    continue;
                }
                $seriesOpen[] = ['name' => $c['name'], 'data' => $openData];
                $seriesClosed[] = ['name' => $c['name'], 'data' => $closedData];
            }

            $chart = [
                'months' => $months,
                'series_open' => $seriesOpen,
                'series_closed' => $seriesClosed,
            ];
        }

        return response()->json([
            'open' => $open,
            'finalized' => $finalized,
            'revenue_total' => (float) $revenueTotal,
            'chart' => $chart,
        ]);
    }
}
