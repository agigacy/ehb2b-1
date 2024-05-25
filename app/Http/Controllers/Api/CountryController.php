<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Support\Facades\Storage;


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
        $countries = Country::with('TourGroups')->get();
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
        $country = new Country;
        $country->fill($request->except(['img_url'])); // 填充其他属性

        // 检查是否有文件上传
        if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
            $file = $request->file('img_url');
            $filename = time() . '.' . $file->getClientOriginalExtension(); // 创建一个基于时间戳的文件名
            $path = $file->storeAs('public/countries', $filename); // 存储文件
            $url = Storage::url($path); // 获取文件的公共URL
            $country->img_url = $url; // 保存文件URL到数据库
        }

        $country->save(); // 保存国家信息到数据库

        return response()->json($country, 201); // 返回新创建的国家信息和201状态码
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
        $country->fill($request->except(['img_url']));

        // if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
        //     // 删除旧文件
        //     if ($country->img_url) {
        //         $oldFile = str_replace('/storage', '', $country->img_url);
        //         Storage::delete('public' . $oldFile);
        //     }

        //     // 上传新文件
        //     $file = $request->file('img_url');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $path = $file->storeAs('public/countries', $filename);
        //     $url = Storage::url($path);
        //     $country->img_url = $url;
        // }
        // 检查是否有文件上传
        if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
            // 删除旧文件
            if ($country->img_url) {
                $oldFile = str_replace('/storage', '', $country->img_url);
                Storage::delete('public' . $oldFile);
                Log::info("Deleted old file at: public" . $oldFile);
            }
            $file = $request->file('img_url');
            $filename = time() . '_' . uniqid();
            $path = $file->storeAs('public/countries', $filename); // 存储文件
            $url = Storage::url($path); // 获取文件的公共URL
            $country->img_url = $url; // 保存文件URL到数据库
        }

        $country->save();
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
