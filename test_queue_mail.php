<?php

require_once 'vendor/autoload.php';

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Foundation\Application;

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::first();
$user->email = 'sobhymenna40@gmail.com';

SendWelcomeEmail::dispatch($user);

echo "Email job dispatched to queue successfully!";
