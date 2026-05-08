<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailSetting\UpdateEmailSettingRequest;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Crypt;

class EmailSettingController extends Controller
{
    private function ensureAdmin(UpdateEmailSettingRequest|\Illuminate\Http\Request $request): void
    {
        $user = $request->user();
        $role = $user?->role ?: 'admin';
        if ($role !== 'admin') {
            abort(403, 'Acesso negado.');
        }
    }

    private function sanitize(EmailSetting $setting): array
    {
        return [
            'id' => $setting->id,
            'enabled' => (bool) $setting->enabled,
            'mailer' => $setting->mailer,
            'host' => $setting->host,
            'port' => $setting->port,
            'username' => $setting->username,
            'encryption' => $setting->encryption,
            'from_address' => $setting->from_address,
            'from_name' => $setting->from_name,
            'has_password' => $setting->password_encrypted ? true : false,
        ];
    }

    public function show(\Illuminate\Http\Request $request)
    {
        $this->ensureAdmin($request);

        $setting = EmailSetting::query()->first();
        if (! $setting) {
            $setting = EmailSetting::create([]);
        }

        return response()->json($this->sanitize($setting));
    }

    public function update(UpdateEmailSettingRequest $request)
    {
        $this->ensureAdmin($request);

        $setting = EmailSetting::query()->first();
        if (! $setting) {
            $setting = EmailSetting::create([]);
        }

        $data = $request->validated();
        $password = trim((string) ($data['password'] ?? ''));
        unset($data['password']);

        if ($password !== '') {
            $data['password_encrypted'] = Crypt::encryptString($password);
        }

        $setting->update($data);

        return response()->json($this->sanitize($setting));
    }
}
