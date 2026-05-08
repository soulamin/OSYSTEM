<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show()
    {
        $company = Company::query()->first();
        if (! $company) {
            $company = Company::create([]);
        }

        return response()->json($company);
    }

    public function update(UpdateCompanyRequest $request)
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if (! in_array($role, ['admin'], true)) {
            abort(403, 'Acesso negado.');
        }

        $company = Company::query()->first();
        if (! $company) {
            $company = Company::create([]);
        }

        $company->update($request->validated());

        return response()->json($company);
    }
}

