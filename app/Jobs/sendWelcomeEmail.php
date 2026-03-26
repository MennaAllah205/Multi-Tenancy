<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithQueue; 

    public $user;

    // public $tries = 3;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // public function retryUntil(): CarbonInterface
    // {
    //     return now()->addSeconds(2);
    // }

    // public function backoff(): array
    // {
    //     return [1, 5, 10];
    // }

    // public function maxExceptions(): int
    // {
    //     return 3;
    // }

    // public function tries(): int
    // {
    //     return 3;
    // }

    public function handle(): void
    {


    try {
  
        Mail::to($this->user->email)
            ->send(new WelcomeMail($this->user));
    } catch (\Exception $e) {
        Log::error('SendWelcomeEmail failed: ' . $e->getMessage());

        $this->release(5);
    }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SendWelcomeEmail failed: ' . $exception->getMessage());
    }
}
