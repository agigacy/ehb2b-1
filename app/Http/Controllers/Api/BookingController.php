<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Passenger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        try {
            // Create Booking object with the main data
            $booking = Booking::create($request->all());

            // Save passengers data
            if ($request->has('passengers')) {
                foreach ($request->passengers as $passengerData) {
                    $passenger = new Passenger($passengerData);
                    $booking->passengers()->save($passenger);
                }
            }

            // Return response with booking data and loaded passengers
            return response()->json($booking->load('passengers'), 201);
        } catch (\Exception $e) {
            // Log any exceptions that occur during the creation process
            \Log::error('Error creating booking:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error creating booking'], 500);
        }
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
