<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Notifications\SubscribeNotification;

class SendSubscriptionExpireNotification implements ShouldQueue
{
    use Queueable;

    public $customers;
    public $expiredSubscriptions;

    /**
     * Create a new job instance.
     */

    protected $title;
    protected $body;

    public function __construct($customers, $expiredSubscriptions, $title, $body)
    {
        $this->customers = $customers;
        $this->expiredSubscriptions = $expiredSubscriptions;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->customers as $customer) {
            $customer->notify(new SubscribeNotification($this->title, $this->body));
            if (!empty($customer->fcm_token)) {
                sendNotification($customer->fcm_token, $this->title, $this->body);
            }
        }
    }
}
