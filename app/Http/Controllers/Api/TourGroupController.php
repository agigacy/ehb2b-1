<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourGroup;
use Illuminate\Support\Facades\DB;

class TourGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TourGroup::with('tours')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return TourGroup::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TourGroup::with('tours', 'country')->find($id);
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
        return TourGroup::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return TourGroup::find($id)->delete();
    }

    // public function getByCountry($countryId)
    // {
    //     $tourGroups = TourGroup::with('tours')
    //                         ->whereHas('country', function ($query) use ($countryId) {
    //                             $query->where('id', $countryId);
    //                         })
    //                         ->get();

    //     return response()->json($tourGroups);
    // }
    public function getByCountry($countryId)
    {
        $tourGroups = TourGroup::with(['tours' => function ($query) {
            $query->with(['bookings.passengers']);
        }])
        ->whereHas('country', function ($query) use ($countryId) {
            $query->where('id', $countryId);
        })
        ->get();

        // 计算每个 tour 的 passengers_count
        foreach ($tourGroups as $group) {
            foreach ($group->tours as $tour) {
                $passengerCount = 0;
                foreach ($tour->bookings as $booking) {
                    $passengerCount += $booking->passengers->count();
                }
                $tour->passengers_count = $passengerCount;
            }
        }

        return response()->json($tourGroups);
    }
}
