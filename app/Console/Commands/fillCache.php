<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class fillCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:fill-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users=User::select('id','phone')->get();
        if(isset($users)&& !empty($users)){
            foreach($users as $user){
                Cache::put('user_phone_'.$user->phone,$user->id);
            }
        }
        
    }
}
