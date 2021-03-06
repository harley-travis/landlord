<?php

namespace App\Http\Controllers;

use Mail;
use Auth;
use App\Company;
use App\Property;
use App\Maintenance;
use App\Tenant;
use App\User;
use Illuminate\Http\Request;
use App\Mail\MaintenanceReview;
use App\Mail\MaintenanceCreated;
use App\Mail\MaintenanceProgress;
use App\Mail\MaintenanceCompleted;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        if( Auth::user()->role === 0 ) {

            $requests = Maintenance::where('user_id', '=', Auth::user()->id)
                ->where('status','!=','3')
                ->orderby('emergency', 'desc')
                ->paginate(15);

        }
        elseif( Auth::user()->role >= 1 ) {

            $requests = Maintenance::where('company_id', '=', Auth::user()->company_id)
                ->where('status','!=','3')
                ->orderby('emergency', 'desc')
                ->paginate(15);

        }

        return view('maintenance.index', ['requests' => $requests]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('maintenance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ]);
        
        $user = Auth::user();

        $maintenance = new Maintenance([
            'subject' => $request->input('subject'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'emergency' => $request->input('emergency'),
            'permission' => $request->input('permission'),
            'status' => 0,
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ]);
        $maintenance->save();

        // locate tenant information
        $tenant = Tenant::where('user_id', '=', $user->id)->first();

        // find tenant information to send to mailable
        $findTenant = Tenant::findOrFail($tenant->id);
        $findUser = User::findOrFail($tenant->user_id); 

        $e = 'travis.harley@senrent.com'; // testing
        $email = $user->email; // live

        Mail::to($e)->send(new MaintenanceCreated($findTenant, $findUser));

        return redirect()
                ->route('maintenance.index')
                ->with('info', 'Good job! Your request was saved sent! We will contact you shortly.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $request = Maintenance::with('user')
                        ->where('maintenances.id', '=', $id)
                        ->first();
        
        return view('maintenance.show', ['request' => $request]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maintenance $maintenance) {
       
        $maintenance = Maintenance::find($request->input('id'));
        $maintenance->status = $request->input('status');
        $maintenance->notes = $request->input('notes');
        $maintenance->save();

        // find tenant information to send to mailable
        $findUser = User::findOrFail($maintenance->user_id); 

        $e = 'travis.harley@senrent.com'; // testing
        $email = $findUser->email; // live

        switch ( $request->input('status') ) {
            case "1":
                Mail::to($e)->send(new MaintenanceReview($findUser));
                break;
            case "2":
                Mail::to($e)->send(new MaintenanceProgress($findUser));
                break;
            case "3":
                Mail::to($e)->send(new MaintenanceCompleted($findUser));
                break;
        }

        return redirect()
                ->route('maintenance.index')
                ->with('info', 'Good job! Your maintenance reqeust was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance $maintenance) {
        //
    }

    public function showArchive() {

        if( Auth::user()->role === 0 ) {

            $requests = Maintenance::where('user_id', '=', Auth::user()->id)
                                ->where('status','=','3')
                                ->paginate(15);

        }
        elseif( Auth::user()->role >= 1 ) {

            $requests = Maintenance::where('company_id', '=', Auth::user()->company_id)
                                ->where('status','=','3')
                                ->paginate(15);

        }

       
        return view('maintenance.archive', ['requests' => $requests]);
    }

    public function progression($id) {
        
        $maintenance = Maintenance::find($id);
        $maintenance->status = $maintenance->status + 1;
        $maintenance->save();

        return redirect()->route('maintenance.index')
                    ->with('info', 'The maintenance request was successfully updated!');

    }

}
