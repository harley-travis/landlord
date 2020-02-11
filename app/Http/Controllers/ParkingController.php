<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Property;
use App\Rent;
use App\Tenant;
use App\Company;
use App\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $properties = Property::where('assigned_parking', '=', '0')
                            ->where('company_id', '=', Auth::user()->company_id)
                            ->get();

        $avaliable = Parking::where('parkings.company_id', '=', Auth::user()->company_id)
                            ->where('avaliable', '=', 0)
                            ->paginate(15);

        $occupied = Property::join('parkings', 'parkings.property_id', '=', 'properties.id')
                            ->where('properties.company_id', '=', Auth::user()->company_id)
                            ->where('parkings.avaliable', '=', 1)
                            ->paginate(15);
        
        return view('property.parking.index', [
            'occupied' => $occupied,
            'avaliable' => $avaliable,
            'properties' => $properties,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('property.parking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $request->validate([
            'location' => 'required',
            'type' => 'required',
        ]);

        $parking = new Parking([
            'location' => $request->input('location'),
            'type' => $request->input('type'),
            'parking_deposit_amount' => $request->input('parking_deposit_amount'),
            'monthly_fee' => $request->input('monthly_fee'),
            'avaliable' => 0,
            'company_id' => Auth::user()->company_id, 
        ]);
        $parking->save();

        return redirect()
                ->route('property.parking')
                ->with('info', 'Good job! Your parking space was saved successfully! You can now assign a parking space to a property.');

    }

    public function assignProperty(Request $request) {

        $parking = Parking::where('id', '=', $request->input('parking_id'))->first(); 
        $parking->avaliable = 1;
        $parking->property_id = $request->input('property_id');
        $parking->save();

        $property = Property::where('id', '=', $request->input('property_id'))->first();
        $property->assigned_parking = 1;
        $property->save();

        return redirect()->route('property.parking')
                ->with('info', 'The parking space was successfully assigned to the property');
    }

    public function unassignProperty(Request $request) {

        $parking = Parking::where('id', '=', $request->input('parking_id'))->first(); 
        $parking->avaliable = 0;
        $parking->property_id = $request->input('property_id');
        $parking->save();

        $property = Property::where('id', '=', $request->input('property_id'))->first();
        $property->assigned_parking = 0;
        $property->save();

        return redirect()->route('property.parking')
                ->with('info', 'The parking space was successfully unassigned from the property');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function show(Parking $parking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
        $parking = Parking::where('id', '=', $id)->first();

        return view('property.parking.edit', [
            'parking' => $parking, 
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parking $parking) {
        
        $request->validate([
            'location' => 'required',
            'type' => 'required',
        ]);

        $parking = Parking::find($request->input('parking_id'));
        $parking->location = $request->input('location');
        $parking->type = $request->input('type');
        $parking->parking_deposit_amount = $request->input('parking_deposit_amount');
        $parking->monthly_fee = $request->input('monthly_fee');
        $parking->save();

        return redirect()->route('property.parking')
                ->with('info', 'The parking space was successfully updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $parking = Parking::find($id);

        // if there is a property tied to the parking space, update the property table
        if( $parking->property_id != null || !isset($parking->property_id) ) {
            
            $property = Property::where('id', '=', $parking->property_id)->first();
            $property->assigned_parking = 0;
            $property->save();

        }

        $parking->delete();

        return redirect()
            ->route('property.parking')
            ->with('info', 'Your property was successfully deleted');
    }
}
