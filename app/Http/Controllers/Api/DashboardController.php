<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

        return response()->json([
            'open' => $open,
            'finalized' => $finalized,
            'revenue_total' => (float) $revenueTotal,
        ]);
    }
}
