<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        // return Country::all();
        $countries = Country::with('tours')->get();
        return response()->json($countries);
        // $query = Country::query();

        // if ($request->has('country_id')) {
        //     $countryId = $request->input('country_id');
        //     $query->where('country_id', $countryId);
        // }

        // $tours = $query->get();

        // return response()->json($tours);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country = Country::create($request->all());
        return response()->json($country, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Country::findOrFail($id);
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
        $country = Country::findOrFail($id);
        $country->update($request->all());
        return response()->json($country, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::destroy($id);
        return response()->json(null, 204);
    }
}
