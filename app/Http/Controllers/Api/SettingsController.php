<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;
use App\Models\UserSetting;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getGlobalSettings()
    // {
    //     return GlobalSetting::all();
    // }

    public function getUserSettings($userId)
    {
        return UserSetting::where('user_id', $userId)->get();
    }

    // public function getUserSetting($userId, $key)
    // {
    //     return UserSetting::where('user_id', $userId)->where('key', $key)->first();
    // }

    public function editUserSetting($userId, $key, $value)
    {
        return UserSetting::where('user_id', $userId)->where('key', $key)->update(['value' => $value]);
    }

    public function index()
    {
        return GlobalSetting::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return GlobalSetting::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return GlobalSetting::find($id);
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
        return GlobalSetting::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return GlobalSetting::find($id)->delete();
    }
}
