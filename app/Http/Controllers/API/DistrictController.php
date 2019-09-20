<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\District; 
class DistrictController extends Controller
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
        return District::latest()->paginate(15);
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
            'name' => 'required|string|unique:districts',
            'code'=>'required|integer|unique:districts',
        ]);
       
        $user = District::create([
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
        $country=District::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|unique:districts,name,'.$country->id,
            'code' => 'required|unique:districts,code,'.$country->id,
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
        $country=District::findOrFail($id);
        $country->delete();
    }
}
