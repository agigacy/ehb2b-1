<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::with('roles', 'permissions')->get(); // 加载角色和权限关联关系
        $users = User::all();
        return UserResource::collection($users); // 使用 UserResource 序列化用户数据并返回
//         $users = User::with('groups','roles')->get();
// return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //     $user = User::findOrFail($id);
    // $permissions = $user->getAllPermissions(); // 直接获取权限数据看是否有返回
    // dd($permissions); // 调试输出
        // $user = User::findOrFail($id);
        // $user->load('roles', 'permissions'); // 确保加载了角色和权限关系
        // return response()->json($user);
        $user = User::findOrFail($id);
    return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        if ($request->has('password')) {
            $input['password'] = Hash::make($request->password);
        }
        $user->update($input);
        if ($request->has('groups')) {
            $user->groups()->sync($request->groups);
        }
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(null, 204);
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        // Assign the user to the groups
        if ($request->has('groups')) {
            $user->groups()->sync($request->groups);
        }

        // Assign the user to the roles
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
    
        // Return a successful response
        return response()->json($user->load('groups'), 201);
    }

    public function getGroups()
    {
        return Group::all();
    }

    public function assignGroups(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->groups()->sync($request->groups);
        return response()->json($user->groups, 200);
    }
    public function removeGroups(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->groups()->detach($request->groups);
        return response()->json($user->groups, 200);
    }


}
