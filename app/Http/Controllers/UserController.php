<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'username'=> 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'sometimes'
        ]);

        $user = new User([
            'name' => $request->name,
            'username'=> $request->username,
            'email'=> $request->email,
            'password' => $request->password,
            'confirm_password' => $request->confirm_password
        ]);
        $user->save();

        return redirect('/user')->with('success', 'User has been added');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('edit', compact('user'));
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
        //return redirect('user');

        $user = User::find($id);

        if($request->name != $user->name){
            $request->validate([
                'name'=>'required'
              ]);
        }
        if($request->username != $user->username){
            $request->validate([
                'username'=> 'required|unique:users'
              ]);
        }
        if($request->email != $user->email){
            $request->validate([
                'email' => 'required|unique:users'
              ]);
        }


          $user->name = $request->name;
          $user->username = $request->username;
          $user->email = $request->email;
          $user->save();

          return redirect('/user')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/user')->with('success', 'User has been deleted Successfully');
    }
}
