<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Service;
use App\Services\OrderPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    private function sanitizeOrderForRole(Order $order, string $role): array
    {
        $data = $order->toArray();

        if ($role === 'admin') {
            return $data;
        }

        unset($data['total_value']);

        if (isset($data['services']) && is_array($data['services'])) {
            foreach ($data['services'] as $i => $s) {
                if (is_array($s)) {
                    unset($s['value']);
                    if (isset($s['pivot']) && is_array($s['pivot'])) {
                        unset($s['pivot']['unit_value']);
                    }
                    $data['services'][$i] = $s;
                }
            }
        }

        return $data;
    }

    private function ensureCanManage(Request $request): void
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if (in_array($role, ['admin', 'tecnico'], true)) {
            return;
        }

        abort(403, 'Acesso negado.');
    }

    private function ensureCanAccessOrder(Request $request, Order $order): void
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';

        if ($role === 'admin') {
            return;
        }

        if ($role === 'tecnico') {
            if ((int) ($order->responsible_user_id ?? 0) !== (int) ($user?->id ?? 0)) {
                abort(403, 'Acesso negado.');
            }
            return;
        }

        if ((int) ($user?->client_id ?? 0) !== (int) $order->client_id) {
            abort(403, 'Acesso negado.');
        }
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        $userId = (int) ($user?->id ?? 0);

        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = Order::query()
            ->select([
                'id',
                'number',
                'client_id',
                'responsible_user_id',
                'status',
                'opened_at',
                'closed_at',
                'notes',
                'total_value',
                'created_at',
                'updated_at',
            ])
            ->with(['client', 'responsible']);

        if ($role === 'cliente') {
            $clientId = (int) ($user?->client_id ?? 0);
            if ($clientId <= 0) {
                abort(403, 'Acesso negado.');
            }
            $query->where('client_id', $clientId);
        }

        if ($role === 'tecnico') {
            if ($userId <= 0) {
                abort(403, 'Acesso negado.');
            }
            $query->where('responsible_user_id', $userId);
        }

        if ($request->filled('status')) {
            $query->where('status', (string) $request->query('status'));
        }

        if ($role === 'admin' && $request->filled('client_id')) {
            $query->where('client_id', (int) $request->query('client_id'));
        }

        if ($request->filled('from')) {
            $query->whereDate('opened_at', '>=', (string) $request->query('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('opened_at', '<=', (string) $request->query('to'));
        }

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));

            $query->where(function ($sub) use ($q) {
                $sub->where('number', 'like', "%{$q}%")
                    ->orWhereHas('client', function ($client) use ($q) {
                        $client->where('name', 'like', "%{$q}%")
                            ->orWhere('document', 'like', "%{$q}%");
                    })
                    ->orWhereHas('responsible', function ($responsible) use ($q) {
                        $responsible->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        $query->orderByDesc('opened_at');

        $paginator = $query->paginate($perPage);
        $paginator->getCollection()->transform(function (Order $order) use ($role) {
            return $this->sanitizeOrderForRole($order, $role);
        });

        return response()->json($paginator);
    }

    public function store(StoreOrderRequest $request)
    {
        $this->ensureCanManage($request);

        $user = $request->user();
        $role = $user?->role ?: 'admin';

        $data = $request->validated();
        $serviceItems = $data['services'];

        $order = DB::transaction(function () use ($request, $data, $serviceItems, $role) {
            $nextNumber = ((int) Order::query()->lockForUpdate()->max('number')) + 1;

            $status = $data['status'] ?? Order::STATUS_ABERTA;
            $openedAt = $data['opened_at'] ?? now();
            $closedAt = in_array($status, [Order::STATUS_FINALIZADA, Order::STATUS_CANCELADA], true) ? now() : null;

            $responsibleUserId = (int) ($request->user()?->id ?? 0);
            if ($role === 'admin' && ! empty($data['responsible_user_id'])) {
                $responsibleUserId = (int) $data['responsible_user_id'];
            }

            $order = Order::create([
                'number' => $nextNumber,
                'client_id' => $data['client_id'],
                'client_name' => $data['client_name'] ?? null,
                'client_document' => $data['client_document'] ?? null,
                'responsible_user_id' => $responsibleUserId,
                'status' => $status,
                'opened_at' => $openedAt,
                'closed_at' => $closedAt,
                'notes' => $data['notes'] ?? null,
                'solution' => $data['solution'] ?? null,
                'signature_image' => $data['signature_image'] ?? null,
                'signature_signed_at' => $status === Order::STATUS_FINALIZADA ? now() : null,
                'total_value' => 0,
            ]);

            $sync = [];
            $total = 0.0;

            $services = Service::query()
                ->whereIn('id', collect($serviceItems)->pluck('id')->all())
                ->get()
                ->keyBy('id');

            foreach ($serviceItems as $item) {
                $serviceId = (int) $item['id'];
                $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                $service = $services->get($serviceId);

                if (! $service) {
                    continue;
                }

                $unit = (float) $service->value;
                $total += round($unit * $qty, 2);

                $sync[$serviceId] = [
                    'quantity' => $qty,
                    'unit_value' => $unit,
                ];
            }

            $order->services()->sync($sync);
            $order->update(['total_value' => round($total, 2)]);

            return $order->load(['client', 'services', 'responsible']);
        });

        if ($role === 'admin' && $order->status === Order::STATUS_FINALIZADA && $order->signature_image && $order->solution) {
            app(OrderPdfService::class)->generateAndStore($order);
        }
        if (in_array($order->status, [Order::STATUS_ABERTA, Order::STATUS_EM_ANDAMENTO], true) && ! $order->pdf_path) {
            app(OrderPdfService::class)->generateAndStore($order);
        }
        if ($order->status === Order::STATUS_FINALIZADA && $order->signature_image && $order->solution) {
            app(OrderPdfService::class)->sendClosedEmails($order);
        } elseif (in_array($order->status, [Order::STATUS_ABERTA, Order::STATUS_EM_ANDAMENTO], true)) {
            app(OrderPdfService::class)->sendOpenedEmails($order);
        }

        return response()->json($this->sanitizeOrderForRole($order, $role), 201);
    }

    public function show(Request $request, Order $order)
    {
        $this->ensureCanAccessOrder($request, $order);

        $user = $request->user();
        $role = $user?->role ?: 'admin';

        $order->loadMissing(['client', 'services', 'responsible']);

        return response()->json($this->sanitizeOrderForRole($order, $role));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->ensureCanAccessOrder($request, $order);

        $user = $request->user();
        $role = $user?->role ?: 'admin';
        $originalStatus = $order->status;

        $data = $request->validated();
        if ($role === 'cliente') {
            $allowed = ['signature_image'];
            $data = array_intersect_key($data, array_flip($allowed));
        }

        $updated = DB::transaction(function () use ($request, $order, $data) {
            $originalStatus = $order->status;

            if (array_key_exists('client_id', $data)) {
                $order->client_id = $data['client_id'];
            }

            if (array_key_exists('client_name', $data)) {
                $order->client_name = $data['client_name'];
            }

            if (array_key_exists('client_document', $data)) {
                $order->client_document = $data['client_document'];
            }

            if (array_key_exists('opened_at', $data)) {
                $order->opened_at = $data['opened_at'];
            }

            if (array_key_exists('notes', $data)) {
                $order->notes = $data['notes'];
            }

            if (array_key_exists('solution', $data)) {
                $order->solution = $data['solution'];
            }

            if (array_key_exists('status', $data)) {
                $order->status = $data['status'];
            }

            $user = $request->user();
            $role = $user?->role ?: 'admin';
            if ($role === 'admin' && array_key_exists('responsible_user_id', $data)) {
                $order->responsible_user_id = $data['responsible_user_id'];
            }
            if ($role !== 'cliente') {
                $order->responsible_user_id = $order->responsible_user_id ?? $user?->id;
            }

            if (array_key_exists('signature_image', $data) && trim((string) $data['signature_image']) !== '') {
                $order->signature_image = $data['signature_image'];
                $order->signature_signed_at = $order->signature_signed_at ?? now();
            }

            if (in_array($order->status, [Order::STATUS_FINALIZADA, Order::STATUS_CANCELADA], true)) {
                $order->closed_at = $order->closed_at ?? now();
            } else {
                $order->closed_at = null;
            }

            if ($order->status === Order::STATUS_FINALIZADA && $originalStatus !== Order::STATUS_FINALIZADA) {
                $order->signature_signed_at = now();
            }

            $total = (float) $order->total_value;

            if (array_key_exists('services', $data)) {
                $serviceItems = $data['services'];
                $sync = [];
                $total = 0.0;

                $services = Service::query()
                    ->whereIn('id', collect($serviceItems)->pluck('id')->all())
                    ->get()
                    ->keyBy('id');

                foreach ($serviceItems as $item) {
                    $serviceId = (int) $item['id'];
                    $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                    $service = $services->get($serviceId);

                    if (! $service) {
                        continue;
                    }

                    $unit = (float) $service->value;
                    $total += round($unit * $qty, 2);

                    $sync[$serviceId] = [
                        'quantity' => $qty,
                        'unit_value' => $unit,
                    ];
                }

                $order->services()->sync($sync);
            }

            $order->total_value = round($total, 2);
            $order->save();

            return $order->load(['client', 'services', 'responsible']);
        });

        if ($role === 'admin' && $updated->status === Order::STATUS_FINALIZADA && $updated->signature_image && $updated->solution) {
            app(OrderPdfService::class)->generateAndStore($updated);
        }
        if ($originalStatus !== Order::STATUS_FINALIZADA && $updated->status === Order::STATUS_FINALIZADA && $updated->signature_image && $updated->solution) {
            app(OrderPdfService::class)->sendClosedEmails($updated);
        } elseif (
            ! in_array($originalStatus, [Order::STATUS_ABERTA, Order::STATUS_EM_ANDAMENTO], true)
            && in_array($updated->status, [Order::STATUS_ABERTA, Order::STATUS_EM_ANDAMENTO], true)
        ) {
            app(OrderPdfService::class)->sendOpenedEmails($updated);
        }

        return response()->json($this->sanitizeOrderForRole($updated, $role));
    }

    public function destroy(Request $request, Order $order)
    {
        $this->ensureCanManage($request);

        $order->delete();

        return response()->json(['message' => 'Ordem de serviço excluída com sucesso.']);
    }

    public function pdf(Request $request, Order $order)
    {
        $this->ensureCanAccessOrder($request, $order);

        $user = $request->user();
        $role = $user?->role ?: 'admin';
        $hideValues = $role !== 'admin';
        $context = $order->status === Order::STATUS_FINALIZADA ? 'closed' : 'opened';

        $order->loadMissing(['client', 'services', 'responsible']);
        $company = Company::query()->first();

        if (! $hideValues && $order->status === Order::STATUS_FINALIZADA && $order->signature_image && $order->solution && ! $order->pdf_path) {
            app(OrderPdfService::class)->generateAndStore($order);
        }

        if (! $hideValues && $order->pdf_path && Storage::disk('local')->exists($order->pdf_path)) {
            $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
            return Storage::disk('local')->download($order->pdf_path, "OS-{$safeNumber}.pdf");
        }

        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.order', [
            'order' => $order,
            'company' => $company,
            'hideValues' => $hideValues,
            'context' => $context,
        ])->setPaper('a4');
        return $pdf->download("OS-{$safeNumber}.pdf");
    }
}
