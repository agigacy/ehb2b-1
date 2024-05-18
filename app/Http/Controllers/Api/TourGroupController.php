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
    // public function getByCountry($countryId)
    // {
    //     $tourGroups = TourGroup::with(['tours' => function ($query) {
    //         $query->with(['bookings.passengers']);
    //     }])
    //     ->whereHas('country', function ($query) use ($countryId) {
    //         $query->where('id', $countryId);
    //     })
    //     ->get();

    //     // 计算每个 tour 的 passengers_count
    //     foreach ($tourGroups as $group) {
    //         foreach ($group->tours as $tour) {
    //             $passengerCount = 0;
    //             foreach ($tour->bookings as $booking) {
    //                 $passengerCount += $booking->passengers->count();
    //             }
    //             $tour->passengers_count = $passengerCount;
    //         }
    //     }

    //     return response()->json($tourGroups);
    // }
    public function getByCountry($countryId)
    {
        $user = auth()->user();
        \Log::info('User:', ['user' => $user]); // 查看日志文件确认用户信息
    
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        $groups = $user->groups;
    
        if ($groups->isEmpty()) {
            return response()->json(['message' => 'User has no associated group'], 400);
        }
    
        // 假设每个用户只属于一个组，或者您需要决定如何处理多个组
        $group = $groups->first();
        $accessibleTiers = $group->getAccessibleTiers();
    
        $tourGroups = TourGroup::with(['tours' => function ($query) {
            $query->with(['bookings.passengers']);
        }])
        ->whereHas('country', function ($query) use ($countryId) {
            $query->where('id', $countryId);
        })
        ->get();
    
        // 计算每个 tour 的 passengers_count 并添加 accessible_tiers
        foreach ($tourGroups as $group) {
            foreach ($group->tours as $tour) {
                $passengerCount = 0;
                foreach ($tour->bookings as $booking) {
                    $passengerCount += $booking->passengers->count();
                }
                $tour->passengers_count = $passengerCount;
                $tour->accessible_tiers = $accessibleTiers; // 添加层级信息
            }
        }
    
        return response()->json($tourGroups);
    }
}
