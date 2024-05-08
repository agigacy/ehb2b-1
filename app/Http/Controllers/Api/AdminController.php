<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLogin;

class AdminController extends Controller
{
    public function activeLogins()
    {
        // $logins = UserLogin::with('user')->latest()->get();
        // return response()->json($logins);
        // $activeTokens = \DB::table('personal_access_tokens')->get();

        // return response()->json($activeTokens);
        $activeTokens = \DB::table('personal_access_tokens')
        ->join('users', 'users.id', '=', 'personal_access_tokens.tokenable_id')
        ->select('personal_access_tokens.*', 'users.name as username')
        ->get();

        return response()->json($activeTokens);
    }
    public function kickUser($tokenId)
    {
        $token = \Laravel\Sanctum\PersonalAccessToken::find($tokenId);
        if ($token) {
            $token->delete();
            return response()->json(['message' => 'Token revoked successfully'], 200);
        }
        return response()->json(['message' => 'Token not found'], 404);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
