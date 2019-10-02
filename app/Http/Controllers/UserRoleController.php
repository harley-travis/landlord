<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Company;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = User::where('company_id', '=',  Auth::user()->company_id)
                        ->where('role', '!=', '0')
                        ->where('role', '!=', '100')
                        ->get();

        return view('users.index', ['users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $u = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make( $request->input('password')),
            'company_id'=> Auth::user()->company_id,
            'role' => $request->input('role'),
        ]);
        $u->save();

        return redirect()
                ->route('users.index')
                ->with('info', 'Good job! The user saved successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $user = User::where('id', '=', $id)->first();
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        
        $u = User::find($request->input('id'));
        $u->name = $request->input('name');
        $u->email = $request->input('email');
        $u->role = $request->input('role');
        $u->save();

        return redirect()
                ->route('users.index')
                ->with('info', 'Good job! Your user was updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRole $userRole)
    {
        //
    }

    public function showArchive() {

        $users = User::where('company_id', '=',  Auth::user()->company_id)
        ->where('role', '=', '100')
        ->get();

        return view('users.archive', ['users' => $users]);
    }

    public function archive($id) {

        $u = User::find($id);
        $u->role = 100;
        $u->save();

        return redirect()->route('users.index')->with('info', 'The user was successfully archived');
    }
}
