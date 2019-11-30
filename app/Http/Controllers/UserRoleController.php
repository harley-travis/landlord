<?php

namespace App\Http\Controllers;

use Mail;
use Auth;
use App\User;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\InternalUserCreated;

class UserRoleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = User::where('company_id', '=',  Auth::user()->company_id)
                        ->where('role', '!=', '0')
                        ->where('role', '!=', '100')
                        ->paginate(15);

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

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);
        
        $u = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make( $request->input('password')),
            'company_id'=> Auth::user()->company_id,
            'role' => $request->input('role'),
            'product'=> Auth::user()->product,
        ]);
        $u->save();

        // testing email
        //$e = 'travis.harley@senrent.com';
        //Mail::to($e)->send(new InternalUserCreated($u));

        // live
        Mail::to($u->email)->send(new UserCreated($u));

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
    public function update(Request $request, User $user) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);
                
        $user = User::find($request->input('id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

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
                    ->paginate(15);

        return view('users.archive', ['users' => $users]);
    }

    public function archive($id) {

        $user = User::find($id);
        $user->role = '100'; // 100 > inactive
        $user->save();

        return redirect()->route('users.index')->with('info', 'The user was successfully archived');
    }
}
