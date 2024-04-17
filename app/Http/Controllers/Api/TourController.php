<?php

namespace App\Http\Controllers\Api;

use App\Models\Tour;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Tour::all();
        $tours = Tour::with('country','flight_tickets')->get();
        return response()->json($tours, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        if ($request->has('flight_tickets')) {
            $tour->flight_tickets()->sync($request->flight_tickets);
        }
        return response()->json($tour, 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Tour::findOrFail($id);
        return Tour::with('country')->findOrFail($id);
        // return Tour::with('country')->findOrFail($id)->append('country_name');
        // $tour = Tour::with('country')->findOrFail($id);
        // return $tour->append('country_name');
        
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
        $tour = Tour::findOrFail($id);
        $tour->update($request->all());
        if ($request->has('flight_tickets')) {
            $tour->flight_tickets()->sync($request->flight_tickets);
        }
        return response()->json($tour, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Tour::destroy($id);
        $tour = Tour::findOrFail($id);
        $tour->flight_tickets()->detach($request->flight_tickets);
        return response()->json(null, 204);
    }

    public function duplicate(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        $newTour = $tour->replicate();

        // Override the fields with the new values from the request
        $newTour->fill($request->all());

        $newTour->save();

        return response()->json($newTour, 201);
    }
    
    public function report($tourId)
    {
        // 通过ID查找特定的Tour，并预加载它的Bookings以及Bookings的Passengers
        // $tour = Tour::findOrFail($id);
        $tour = Tour::with(['bookings.passengers','country','flight_tickets'])->findOrFail($tourId);
    
        // 直接返回这个特定的Tour及其Bookings和Bookings的Passengers
        return response()->json($tour);
    }
}
