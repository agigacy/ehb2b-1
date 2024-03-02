<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Session::flush();

        // Auth::logout();

        // return redirect('login');

        // auth()->guard('web')->logout();

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);

    }
}
