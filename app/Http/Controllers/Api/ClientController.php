<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
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
        $user = $request->user();
        $role = $user?->role ?: 'admin';

        if ($role === 'cliente') {
            $clientId = (int) ($user?->client_id ?? 0);
            if ($clientId <= 0) {
                abort(403, 'Acesso negado.');
            }

            return response()->json(Client::query()->whereKey($clientId)->get());
        }

        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = Client::query();

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));

            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('document', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $query->orderBy('name');

        if ($request->boolean('all')) {
            return response()->json($query->limit(1000)->get());
        }

        return response()->json($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $this->ensureCanManage($request);

        $data = $request->validated();

        $client = Client::create($data);

        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Client $client)
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if ($role === 'cliente' && (int) ($user?->client_id ?? 0) !== (int) $client->id) {
            abort(403, 'Acesso negado.');
        }

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->ensureCanManage($request);

        $data = $request->validated();

        $client->update($data);

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Client $client)
    {
        $this->ensureCanManage($request);

        if ($client->orders()->exists()) {
            return response()->json(['message' => 'Não é possível excluir: cliente possui ordens de serviço.'], 422);
        }

        $client->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso.']);
    }
}
