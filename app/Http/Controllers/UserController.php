<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UsersResources;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Cache;


class UserController extends Controller
{
    public function index(Request $request)
    {

 $users = Cache::remember('users_all', 60*60, function () {
        return User::all();
    });
        return UsersResources::collection($users);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();

            DB::transaction(function () use ($data, &$users) {

                $users = User::create($data);

            });

            return backWithSuccess(
                data: new UsersResources($users)
            );

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $user) {

                $user->update($data);

                if (isset($data['password'])) {
                    $user->tokens()->delete();
                }
            });

            return backWithSuccess(
                data: new UsersResources($user)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {

            $user->delete();

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
