<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;

class DatabaseBackupController extends Controller
{
    private function ensureAdmin(Request $request): void
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';

        if ($role !== 'admin') {
            abort(403, 'Acesso negado.');
        }
    }

    public function download(Request $request, DatabaseBackupService $service)
    {
        $this->ensureAdmin($request);

        try {
            $backup = $service->createBackup();

            return response()->download($backup['path'], $backup['filename'], [
                'Content-Type' => 'application/octet-stream',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage() ?: 'Falha ao gerar o backup do banco de dados.',
            ], 500);
        }
    }
}
