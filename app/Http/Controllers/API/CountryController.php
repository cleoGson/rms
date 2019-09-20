<?php

namespace App\Http\Controllers\API;
use App\Model\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
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
        return Country::latest()->paginate(15);
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
            'name' => 'required|string|unique:countries',
            'code'=>'required|integer|unique:countries',
        ]);
       
        $user = Country::create([
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
        $country=Country::findOrFail($id);
        dd($id);
        $this->validate($request, [
            'name' => 'required|unique:countries,name,'.$country->id,
            'code' => 'required|unique:countries,code,'.$country->id,
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
      $country=Country::findOrFail($id);
      $country->delete();
    }
}
