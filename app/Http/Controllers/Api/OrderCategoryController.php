<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCategory\StoreOrderCategoryRequest;
use App\Http\Requests\OrderCategory\UpdateOrderCategoryRequest;
use App\Models\OrderCategory;
use Illuminate\Http\Request;

class OrderCategoryController extends Controller
{
    private function ensureAdmin(Request $request): void
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if ($role !== 'admin') {
            abort(403, 'Acesso negado.');
        }
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = OrderCategory::query();

        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));
            $query->where('name', 'like', "%{$q}%");
        }

        $query->orderBy('name');

        if ($request->boolean('all')) {
            return response()->json($query->limit(1000)->get());
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(StoreOrderCategoryRequest $request)
    {
        $this->ensureAdmin($request);

        $category = OrderCategory::create($request->validated());

        return response()->json($category, 201);
    }

    public function show(Request $request, OrderCategory $order_category)
    {
        return response()->json($order_category);
    }

    public function update(UpdateOrderCategoryRequest $request, OrderCategory $order_category)
    {
        $this->ensureAdmin($request);

        $order_category->update($request->validated());

        return response()->json($order_category);
    }

    public function destroy(Request $request, OrderCategory $order_category)
    {
        $this->ensureAdmin($request);

        $order_category->delete();

        return response()->json(['message' => 'Categoria excluída com sucesso.']);
    }
}
