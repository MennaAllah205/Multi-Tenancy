<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'John Doe',
                'subscription_end_date' => Carbon::now()->addMonths(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'subscription_end_date' => Carbon::now()->addMonths(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob Johnson',
                'subscription_end_date' => Carbon::now()->addYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Brown',
                'subscription_end_date' => Carbon::now()->subMonth(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Charlie Wilson',
                'subscription_end_date' => Carbon::now()->addMonths(12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Customer::insert($customers);
    }
}
