<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendWelcomeEmail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $data = $request->validated();
        try {

            $loginField = filter_var($data['credential'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';




            $user = User::where($loginField, $data['credential'])->first();

            if (! $user || ! Hash::check($data['password'], $user->password)) {
                return backWithWarning('بيانات غير صالحة', 'Invalid Credentials', 401);
            }

            $token = $user->createToken($request->userAgent())->plainTextToken;


            return backWithSuccess(data: [
                'user' => $user->only('name'),
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();


            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        try {

            $user = User::create($data);



            $token = $user->createToken($request->userAgent())->plainTextToken;

            // Send welcome email
            SendWelcomeEmail::dispatch($user);



            return backWithSuccess(data: [
                'user' => $user->only('name', 'email'),
                'token' => $token,
            ]);
        } catch (\Exception $e) {

            return backWithError($e);
        }
    }
}
