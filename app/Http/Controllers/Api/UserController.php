<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function ensureAdmin(Request $request): void
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if ($role === 'admin') {
            return;
        }

        abort(403, 'Acesso negado.');
    }

    public function index(Request $request)
    {
        $this->ensureAdmin($request);

        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = User::query()->select(['id', 'name', 'email', 'role', 'client_id', 'created_at'])->with('client');

        if ($request->filled('role')) {
            $query->where('role', (string) $request->query('role'));
        }

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $query->orderBy('name');

        if ($request->boolean('all')) {
            return response()->json($query->limit(1000)->get());
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'string', Rule::in(['admin', 'tecnico', 'cliente'])],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
        ]);

        if ($data['role'] === 'cliente' && empty($data['client_id'])) {
            return response()->json(['message' => 'client_id é obrigatório para usuário do tipo cliente.'], 422);
        }

        if ($data['role'] !== 'cliente') {
            $data['client_id'] = null;
        }

        $user = User::create($data);

        return response()->json($user->load('client'), 201);
    }

    public function update(Request $request, User $user)
    {
        $this->ensureAdmin($request);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['sometimes', 'nullable', 'string', 'min:6'],
            'role' => ['sometimes', 'required', 'string', Rule::in(['admin', 'tecnico', 'cliente'])],
            'client_id' => ['sometimes', 'nullable', 'integer', 'exists:clients,id'],
        ]);

        $role = array_key_exists('role', $data) ? $data['role'] : ($user->role ?: 'admin');
        $clientId = array_key_exists('client_id', $data) ? $data['client_id'] : $user->client_id;

        if ($role === 'cliente' && empty($clientId)) {
            return response()->json(['message' => 'client_id é obrigatório para usuário do tipo cliente.'], 422);
        }

        if ($role !== 'cliente') {
            $data['client_id'] = null;
        }

        if (array_key_exists('password', $data) && ($data['password'] === null || trim((string) $data['password']) === '')) {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json($user->fresh()->load('client'));
    }

    public function destroy(Request $request, User $user)
    {
        $this->ensureAdmin($request);

        if ((int) ($request->user()?->id ?? 0) === (int) $user->id) {
            return response()->json(['message' => 'Não é possível excluir o próprio usuário.'], 422);
        }

        if (Order::query()->where('responsible_user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Não é possível excluir: usuário é responsável por ordens de serviço.'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso.']);
    }
}

