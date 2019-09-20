<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use   App\Model\Region;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Region::latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:regions',
            'code'=>'required|integer|unique:regions',
        ]);
       
        $user = Region::create([
            'name' => $request['name'],
            'code' => $request['code'],
        ]);

        return [
            'message'=>'data  saved successfully '
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $country=Region::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|unique:regions,name,'.$country->id,
            'code' => 'required|unique:regions,code,'.$country->id,
        ]);
       $country->update($request->all());
       return [
           'message'=>'data Updated',
       ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country=Region::findOrFail($id);
      $country->delete();
    }
}
