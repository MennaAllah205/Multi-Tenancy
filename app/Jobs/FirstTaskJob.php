<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FirstTaskJob implements ShouldQueue
{
    use Batchable, Dispatchable, Queueable, SerializesModels, InteractsWithQueue; 


    public function __construct()
    {
        //
    }

   
    public function handle(): void
    {
        sleep(2);

        Cache::lock('first-task')->block('10', function () {
            Log::info('FirstTaskJob executed');
        });

    }

   
}
