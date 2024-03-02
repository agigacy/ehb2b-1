<?php

namespace App\Http\Controllers\Api;

use App\Models\FlightTicket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FlightTicket::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $flight_ticket = FlightTicket::create($request->all());
        return response()->json($flight_ticket, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return FlightTicket::findOrFail($id);
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
        $flight_ticket = FlightTicket::findOrFail($id);
        $flight_ticket->update($request->all());
        return response()->json($flight_ticket, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FlightTicket::destroy($id);
        return response()->json(null, 204);
    }
}
