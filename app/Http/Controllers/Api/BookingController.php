<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Reminder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\TourBookingConfirmation;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Booking::all();
        $bookings = Booking::with('user', 'tour','passengers')->get();
        return response()->json($bookings, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try 
        {
            $bookingData = $request->only(['tour_id', 'date', 'total', 'user_id', 'status']);
            $booking = Booking::create($bookingData);

            if ($request->has('passengers')) {
                foreach ($request->passengers as $index => $passengerData) {
                    $passenger = new Passenger([
                        'name' => $passengerData['name'],
                        'passport' => $passengerData['passport'],
                        'date_of_birth' => $passengerData['date_of_birth'],
                        'designation' => $passengerData['designation'],
                        'hp' => $passengerData['hp'],
                        'remark' => $passengerData['remark'],
                        // 确保其他字段也被正确处理
                    ]);
                    if ($request->hasFile("passengers.$index.passport_upload")) {
                        $file = $request->file("passengers.$index.passport_upload");
                        $path = $file->store('public/passports');
                        $url = Storage::url($path);
                        $passenger->passport_upload = $url;
                    }
                    $booking->passengers()->save($passenger);
                }
                
                // Create reminders - Antoney working
                // $this->createReminders($booking);

                // // Send email confirmation
                // Mail::to($request->user()->email)->send(new TourBookingConfirmation($booking));

                // Send email confirmation
                // Mail::to($request->user()->email)->send(new TourBookingConfirmation($booking));
                // Mail::to('test@example.com')->send(new TourBookingConfirmation($booking));


                return response()->json($booking->load('passengers'), 201);

            } 
        }
        catch (\Exception $e) 
        {
            \Log::error('Error creating booking:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error creating booking', 'error' => $e->getMessage()], 500);
        }
    }

    // Antoney working for reminders - booking tour
    private function createReminders($booking)
    {
        $reminders = [];

        // Create the first reminder
        $firstReminderDate = date('Y-m-d H:i:s', strtotime('+24 hours', strtotime($booking->created_at)));
        $reminderBeforeFlight = new Reminder([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'date' => $firstReminderDate,
            'before' => '90',
            'title' => 'First Payment Reminder - Tour Booking',
            'info' => 'Tour Booked Total Amount - ' . $booking->total,
        ]);
        $reminders[] = $reminderBeforeFlight;

        // Create the second reminder
        $secondReminderDate = date('Y-m-d H:i:s', strtotime('+2 weeks', strtotime($booking->created_at)));
        $reminderBeforeTotal = new Reminder([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'date' => $secondReminderDate,
            'before' => '30',
            'title' => 'Second Payment Reminder - Tour Booking',
            'info' => 'Tour Booked Total Amount - ' . $booking->total,
        ]);
        $reminders[] = $reminderBeforeTotal;

        // Insert each reminder individually
        foreach ($reminders as $reminder) {
            $reminder->save();
        }


        // $reminder = new Reminder([
        //     // 'flight_ticket_id' => $booking->flight_ticket_id,
        //     // 'flight_ticket_id' => $booking->tour_id,
        //     'booking_id' => $booking->id,
        //     'user_id' => $booking->user_id,
        //     'date' => $booking->date,
        //     // 'before' => 'Flight', // This indicates it's before the flight
        //     'before' => '90', // This indicates it's before the flight
        //     // Add other fields accordingly
        //     'title' => 'First Payment Reminder - Tour Booking',
        //     'info' => 'Tour Booked Total Amount - ' . $booking->total,
        // ]);

        // $reminder->save();
    }


    public function CY_store(Request $request)
    {
        // 直接创建 Booking 对象，包括 passengers 数据
        $booking = Booking::create($request->all());

        return response()->json($booking->load('passengers'), 201);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'min:1|max:255',
            'passport' => 'min:1|max:255',
            'designation' => 'min:1|max:255',   
            'date_of_birth' => 'min:1|max:255',   
            'hp' => 'min:1|max:255',   
            'passport_upload' => 'file',   
            'remark' => 'max:255',   
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Booking::findOrFail($id);
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
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return response()->json($booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Booking::destroy($id);
        return response()->json(null, 204);
    }
}
