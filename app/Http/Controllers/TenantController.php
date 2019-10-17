<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\User;
use App\Company;
use App\Property;
use App\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Mail;
use App\Mail\TenantCreated;
use App\Mail\RentReminder;

class TenantController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $tenants = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->join('properties', 'tenants.property_id', '=', 'properties.id')
                            ->where('properties.company_id', '=', Auth::user()->company_id)
                            ->where('users.company_id', '=', Auth::user()->company_id)
                            ->where('tenants.active', '=', '1')
                            ->paginate(15);
        
        return view('tenants.index', ['tenants' => $tenants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $properties = Property::where('company_id', '=', Auth::user()->company_id)->get();
        return view('tenants.create', ['properties' => $properties]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $email = $request->input('email');
        
        $u = new User([
            'name' => $request->input('name'),
            'email' => $email,
            'password' => Hash::make( $request->input('password')),
            'company_id'=> Auth::user()->company_id,
            'role' => '0',
            'product' => 0,
        ]);
        $u->save();

        $tenant = new Tenant([
            'phone' => $request->input('phone'),
            'work_phone' => $request->input('work_phone'),
            'secondary_name' => $request->input('secondary_name'),
            'secondary_phone'=> $request->input('secondary_phone'),
            'secondary_work_phone'=> $request->input('secondary_work_phone'),
            'secondary_email'=> $request->input('secondary_email'),
            'number_occupants'=> $request->input('number_occupants'),
            'active' => '1',
            'property_id'=> $request->input('property_id'),
            'user_id' => $u->id,
        ]);
        $tenant->save();

        // need to update the pivot table as well.
        $tenant->company()->attach(Auth::user()->company_id);

        // find the tenant and user
        $findTenant = Tenant::findOrFail($tenant->id);
        $findUser = User::findOrFail($u->id);
        /**
         * this property is used for other email testing
         */
        // $findProperty = Property::findOrFail($tenant->property_id);

        $e = 'travis.harley@senrent.com';

       /**
        * testing version
        */
        Mail::to($e)->send(new TenantCreated($findTenant, $findUser));

        /**
         * this function is to send rent reminder
         */

        //Mail::to($e)->send(new RentReminder($findTenant, $findUser, $findProperty));


        /**
         * This should be the live version
         */
        //Mail::to($email)->send(new TenantCreated($tenant));

        return redirect()
                ->route('tenants.index')
                ->with('info', 'Good job! The tenant saved successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $tenant = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->where('tenants.id', '=', $id)
                            ->first();

        $property = Property::join('tenants', 'properties.id', '=', 'tenants.property_id')
                            ->where('tenants.id', '=', $id)
                            ->first();
                            
        return view('tenants.show', ['tenant' => $tenant, 'property' => $property]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $tenant = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->where('tenants.id', '=', $id)
                            ->first();

        $properties = Property::where('company_id', '=', Auth::user()->company_id)->get();

        return view('tenants.edit', ['tenant' => $tenant, 'tenant_id' => $id, 'properties' => $properties]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant) {

        $user = User::find($request->input('user_id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        $tenant = Tenant::find($request->input('id'));
        $tenant->phone = $request->input('phone');
        $tenant->work_phone = $request->input('work_phone');
        $tenant->secondary_name = $request->input('secondary_name');
        $tenant->secondary_phone = $request->input('secondary_phone');
        $tenant->secondary_work_phone = $request->input('secondary_work_phone');
        $tenant->secondary_email = $request->input('secondary_email');
        $tenant->number_occupants = $request->input('number_occupants');
        $tenant->property_id = $request->input('property_id');
        $tenant->save();

        return redirect()
                ->route('tenants.index')
                ->with('info', 'Good job! Your property was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $tenant = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->where('tenants.id', '=', $id)
                            ->first();
        $tenant->delete();
        return redirect()->route('tenants.index')->with('info', 'The tenant was successfully deleted');
    }

    public function showArchive() {

        $tenants = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->where('users.company_id', '=', Auth::user()->company_id)
                            ->where('tenants.active', '=', '0')
                            ->paginate(15);
                            
        return view('tenants.archive', ['tenants' => $tenants]);
    }

    public function archive($id) {

        $tenant = Tenant::find($id);
        $tenant->active = 0;
        $tenant->save();

        return redirect()->route('tenants.index')->with('info', 'The tenant was successfully archived');
    }
    
}
