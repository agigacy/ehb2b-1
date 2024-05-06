<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ReminderController extends Controller
{
    public function index()
    {
        return Reminder::all();
        // $reminder = Reminder::with('country','flight_tickets')->get();
        // return response()->json($reminder, 200);
    }
}
