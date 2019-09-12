<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
class UserController extends Controller
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
        return User::latest()->paginate(15);
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
            'name' => 'required',
            'photo'=>'mime:jpg,jpeg,svg,png',
            'email' => 'required|email|unique:users',
            'gender'=>'required|string',
            'password'=>'required|min:6',
        ]);
       
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return [
            'message'=>'good job'
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


    public function profile()
    {
      return auth('api')->user();
    }




    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('images/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('images/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        //return $request->all();
        User::where('id',$user->id)->update([
            'name'=>$request->name,
            'photo'=>$request->photo,
            'email'=>$request->email,
            'gender'=>$request->gender
        ]);
        return ['message' => "Success"];
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
        $user=User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'photo'=>'mime:jpg,jpeg,svg,png',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender'=>'required|string',
            'password'=>'sometimes|min:6',
        ]);
       $user->update($request->all());
       return [
           'message'=>'User Updated',
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
    $user=User::findOrFail($id);
    $user->delete();
    }
}
