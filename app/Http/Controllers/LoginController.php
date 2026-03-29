<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $tenant = Tenant::where('code', $request->code)
                ->first();

            if (! $tenant) {
                return response()->json([
                    'message' => 'بيانات الاعتماد غير صالحة',
                ], 401);
            }

            session(['tenant_code' => $tenant->code]);

            Config::set('database.connections.tenant.database', $tenant->db_name);

            DB::purge('tenant');
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');

            $token = Str::random(60);
            $tenant->update(['api_token' => hash('sha256', $token)]);

            return response()->json([
                'message' => 'تم تسجيل الدخول بنجاح',
                'tenant' => $tenant,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
