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


     public function lama_store(Request $request)
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

    public function XX_2store(Request $request)
    {
        try {
            // Create Booking object with the main data
            $booking = Booking::create($request->all());

            // Log the request data to inspect if passengers are present
            \Log::info('Request Data:', $request->all());

            // Log the created booking ID for debugging
            // \Log::info('Created Booking ID:', $booking->id);
            \Log::info('Created Booking ID:', ['booking_id' => $booking->id]);

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

    public function store_hold(Request $request)
    {
        $passengerData = $this->validateRequest();

        // Ensure 'name' field is provided before saving
        if (!isset($passengerData['name'])) {
            return response()->json(['error' => 'Name field is required.'], 400);
        }

        // Continue with saving passenger details
        // Extract passengers data from the request
        $passengersData = $request->input('passengers');

        // Remove passengers data from the main request data
        $bookingData = $request->except('passengers');

        // Serialize passengers data before saving
        $passengersSerialized = array_map(function ($passenger) {
            return serialize($passenger);
        }, $passengersData);

        // Create the booking with the main data
        $booking = Booking::create($bookingData);

        // Save passengers data
        foreach ($passengersSerialized as $passengerData) {
            $passenger = new Passenger($passengerData);
            $booking->passengers()->save($passenger);
        }

        // Return response with booking data and loaded passengers
        return response()->json($booking->load('passengers'), 201);
    }

    public function store_antoney2(Request $request)
    {
        // Log the incoming request data to check the structure
        \Log::info('Request data:', $request->all());

        $passengerData = $this->validateRequest();
        // Validate the request data
        // $request->validate([
        //     'name' => 'required',
        //     // Add validation rules for other passenger fields if necessary
        // ]);
        // Extract passengers data from the request
        $passengersData = $request->input('passengers');

        // Log the extracted passengers data to check the structure
        \Log::info('Passengers data:', $passengersData);

        // Remove passengers data from the main request data
        $bookingData = $request->except('passengers');

        // Serialize passengers data before saving
        $passengersSerialized = array_map(function ($passenger) {
            return serialize($passenger);
        }, $passengersData);

        // Create the booking with the main data
        $booking = Booking::create($bookingData);

        // Save passengers data
        foreach ($passengersSerialized as $passengerData) {
            $booking->passengers()->create(['data' => $passengerData]);
        }
        // foreach ($passengersSerialized as $passengerData) {
        //     $passenger = new Passenger($passengerData);
        //     $booking->passengers()->save($passenger);
        // }

        // Return response with booking data and loaded passengers
        return response()->json($booking->load('passengers'), 201);
    }

    public function store_antoney(Request $request)
    {
        // Extract passengers data from the request
        $passengersData = $request->input('passengers');

        // Remove passengers data from the main request data
        $bookingData = $request->except('passengers');

        // Create the booking with the main data
        $booking = Booking::create($bookingData);

        // Save passengers data
        foreach ($passengersData as $passengerData) {
            $booking->passengers()->create($passengerData);
        }

        // Return response with booking data and loaded passengers
        return response()->json($booking->load('passengers'), 201);
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
