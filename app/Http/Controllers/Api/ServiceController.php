<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private function sanitizeServiceForRole(Request $request, array $data): array
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if ($role === 'admin' || $role === 'tecnico') {
            return $data;
        }

        unset($data['value']);
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = Service::query();

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));

            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $query->orderBy('name');

        if ($request->boolean('all')) {
            $items = $query->limit(1000)->get()->map(function (Service $service) use ($request) {
                return $this->sanitizeServiceForRole($request, $service->toArray());
            })->values();
            return response()->json($items);
        }

        $paginator = $query->paginate($perPage);
        $paginator->getCollection()->transform(function (Service $service) use ($request) {
            return $this->sanitizeServiceForRole($request, $service->toArray());
        });

        return response()->json($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->ensureCanManage($request);

        $data = $request->validated();

        $service = Service::create($data);

        return response()->json($service, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Service $service)
    {
        return response()->json($this->sanitizeServiceForRole($request, $service->toArray()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->ensureCanManage($request);

        $data = $request->validated();

        $service->update($data);

        return response()->json($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Service $service)
    {
        $this->ensureCanManage($request);

        $service->delete();

        return response()->json(['message' => 'Serviço excluído com sucesso.']);
    }
}
