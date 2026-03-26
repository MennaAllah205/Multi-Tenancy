<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetTenantDatabase
{
    public function handle($request, Closure $next)
    {
        $code = $request->header('X-Tenant-Code');
        $token = $request->bearerToken();

        if (! $code) {
            return response()->json([
                'message' => 'كود الشركة مطلوب',
            ], 400);
        }

        if (! $token) {
            return response()->json([
                'message' => 'توكن المصادقة مطلوب',
            ], 401);
        }

        $tenant = Tenant::where('code', $code)->first();

        if (! $tenant) {
            return response()->json([
                'message' => 'كود الشركة غير صالح',
            ], 404);
        }

        if (! $tenant->api_token || ! Hash::check($token, $tenant->api_token)) {
            return response()->json([
                'message' => 'توكن المصادقة غير صالح',
            ], 401);
        }

        Config::set('database.connections.tenant.database', $tenant->db_name);

        DB::purge('tenant');
        DB::reconnect('tenant');

        DB::setDefaultConnection('tenant');

        $request->merge(['tenant_id' => $tenant->id]);

        return $next($request);
    }
}
