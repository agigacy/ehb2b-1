<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException; // 修改这里
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // 加载用户角色和权限
        $user->load('roles', 'permissions');

        return response()->json([
            'user_id' => $user->id,
            'token' => $user->createToken('laravel_api_token')->plainTextToken,
            'roles' => $user->roles->pluck('name'), // 返回角色名称列表
            'permissions' => $user->getAllPermissions()->pluck('name'), // 返回权限名称列表
        ]);
    }

}