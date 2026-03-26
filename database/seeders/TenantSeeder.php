<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'name' => 'Main Tenant',
            'db_name' => 'main_db',
            'db_user' => 'root',
            'db_password' => '',
        ]);

        Tenant::create([
            'name' => 'Company Tenant',
            'db_name' => 'company_db',
            'db_user' => 'root',
            'db_password' => '',
        ]);
    }
}
