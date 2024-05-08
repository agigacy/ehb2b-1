<?php

namespace App\Http\Controllers\Api;

use App\Models\FlightTicket;
use App\Models\Reminder;
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

        // Create reminders - Antoney working
        $this->createReminders($flight_ticket);

        return response()->json($flight_ticket, 201);
    }

    // Antoney working for reminders - Flight ticket purchased
    private function createReminders($flight_ticket)
    {
        $reminders = [];

        // Create the first reminder
        $firstReminderDate = date('Y-m-d H:i:s', strtotime('+24 hours', strtotime($flight_ticket->created_at)));
        $reminderBeforeFlight = new Reminder([
            'flight_ticket_id' => $flight_ticket->id,
            // 'user_id' => $flight_ticket->user_id,
            'user_id' => '1', // Fixed for admin
            'date' => $firstReminderDate,
            'before' => '90',
            'title' => 'First Payment Reminder - Flight Ticket PNR: ' . $flight_ticket->pnr,
            'info' => 'Flight Ticket Details: ' . $flight_ticket->pnr . ' (' . $flight_ticket->airline. ') Seat X ' . $flight_ticket->seat,
        ]);
        $reminders[] = $reminderBeforeFlight;

        // Create the second reminder
        $secondReminderDate = date('Y-m-d H:i:s', strtotime('+2 weeks', strtotime($flight_ticket->created_at)));
        $reminderBeforeTotal = new Reminder([
            'flight_ticket_id' => $flight_ticket->id,
            // 'user_id' => $flight_ticket->user_id,
            'user_id' => '1', // Fixed for admin
            'date' => $secondReminderDate,
            'before' => '30',
            'title' => 'Second Payment Reminder - Flight Ticket PNR: ' . $flight_ticket->pnr,
            'info' => 'Flight Ticket Details: ' . $flight_ticket->pnr . ' (' . $flight_ticket->airline. ') Seat X ' . $flight_ticket->seat,
        ]);
        $reminders[] = $reminderBeforeTotal;

        // Insert each reminder individually
        foreach ($reminders as $reminder) {
            $reminder->save();
        }

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
