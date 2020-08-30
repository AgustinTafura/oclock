<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      echo "string";

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::find($id);
      if($user){
        return view('auth/register', compact('user'));
      } else {
        return redirect('home');
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMe()
    {
      $user = Auth::user();
      return view('auth/register', compact('user'));
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
      $userToUpdate = User::find($id);
      $userToUpdate->validator($request->all())->validate();
      if($request[ 'name']){
        $userToUpdate->name = $request['name'];
      }
      if($request[ 'surname']){
        $userToUpdate->surname = $request['surname'];
      }
      if($request[ 'email']){
        $userToUpdate->email = $request['email'];
      }
      if($request[ 'password']){
        $userToUpdate->password = Hash::make($request['password']);
      }
      if($request[ 'address_id']){
        $userToUpdate->address_id = $request['address_id'];
      }
      if($request['year'] != 0 && $request['month'] != 0 && $request['day'] != 0 ){
        $userToUpdate->birthdate = $request['year'].'-'.$request['month'].'-'.$request['day'];
      }
      if($request[ 'dni']){
        $userToUpdate->dni = $request['dni'];
      }
      if($request[ 'mobile_phone']){
        $userToUpdate->mobile_phone = $request['mobile_phone'];
      }
      if($request[ 'sex']){
        $userToUpdate->sex = $request['sex'];
      }
      if($request[ 'avatar']){
        $userToUpdate->avatar = $request['avatar'];
      }

      $userToUpdate->save();
      $user = Auth::user();
      return view('/home')->with(compact('user'))->with('successMsg','Property is updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
      $this->middleware('auth', ['except' => ['index','show']]);
    }


}
