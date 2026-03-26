<?php

// app/Http/Controllers/TenantController.php

namespace App\Http\Controllers;

use App\Http\Requests\TenantStoreRequest;
use App\Jobs\SendWelcomeEmail;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index()
    {
        return Tenant::all();
    }

    public function store(TenantStoreRequest $request)
    {
        try {
            $tenant = Tenant::create($request->validated());

            DB::statement("CREATE DATABASE IF NOT EXISTS `{$tenant->db_name}`");

            $this->setTenantDatabase($tenant);

            Artisan::call('migrate --seed');

            return backWithSuccess(data: $tenant);

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function update(Request $request, Tenant $tenant)
    {
        $tenant->update($request->all());

        return backWithSuccess(data: $tenant);

    }

    public function destroy(Tenant $tenant)
    {
        DB::statement("DROP DATABASE IF EXISTS `{$tenant->db_name}`");
        $tenant->delete();

        return backWithSuccess();

    }

    private function setTenantDatabase(Tenant $tenant)
    {
        Config::set('database.connections.tenant.database', $tenant->db_name);

        DB::purge('tenant');
        DB::reconnect('tenant');

        DB::setDefaultConnection('tenant');
    }
}
