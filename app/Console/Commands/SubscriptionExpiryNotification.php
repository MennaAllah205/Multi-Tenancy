<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Customer;
use App\Jobs\SendSubscriptionExpireNotification;

class SubscriptionExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription expiry and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();

        $customers = Customer::where('subscription_end_date', '<=', $today)->get();
        $expiredSubscriptions = $customers->pluck('subscription_end_date')->unique();
        //  dd($customers);


        dispatch(new SendSubscriptionExpireNotification($customers, $expiredSubscriptions, 'Subscription Expired', 'Your subscription has expired'));
    }
}
