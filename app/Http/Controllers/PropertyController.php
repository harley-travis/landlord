<?php

namespace App\Http\Controllers;

use Auth;
use App\Property;
use App\Company;
use App\Community;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class PropertyController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $properties = Property::where('company_id', '=', Auth::user()->company_id)->paginate(15);

        $communities = Community::join('properties', 'communities.id', '=', 'properties.community_id')
        ->where('communities.company_id', '=', Auth::user()->company_id)
        ->paginate(15);

        // $communities = Property::join('communities', 'properties.community_id', '=', 'communities.id')
        //                     ->where('properties.company_id', '=', Auth::user()->company_id)
        //                     ->paginate(15);
        
        $company = Company::where('id', '=', Auth::user()->company_id)->first();
        
        return view('property.index', [
            'properties' => $properties, 
            'communities' => $communities, 
            'company' => $company,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $communities = Community::where('company_id', '=', Auth::user()->company_id)->get();
        return view('property.create', ['communities' => $communities]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $property = new Property([
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'address_3' => $request->input('address_3'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip'=> $request->input('zip'),
            'country'=> $request->input('country'),
            'occupied'=> $request->input('occupied'),
            'lease_length'=> $request->input('lease_length'),
            'rent_amount'=> $request->input('rent_amount'),
            'pet'=> $request->input('pet'),
            'deposit_amount'=> $request->input('deposit_amount'),
            'pet_deposit_amount'=> $request->input('pet_deposit_amount'),
            'amount_refundable'=> $request->input('amount_refundable'),
            'bed_amount'=> $request->input('bed_amount'),
            'bath_amount'=> $request->input('bath_amount'),
            'square_footage'=> $request->input('square_footage'),
            'description'=> $request->input('description'),
            'account_number'=> $request->input('account_number'),
            'hoa_amount'=> $request->input('hoa_amount'),
            'community_id'=> $request->input('community_id'),
            'company_id' => Auth::user()->company_id,
        ]);
        $property->save();

        return redirect()
                ->route('property.index')
                ->with('info', 'Good job! Your property was saved successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $property = Property::where('company_id', '=', Auth::user()->company_id)->first();
        $communities = Community::where('company_id', '=', Auth::user()->company_id)->get();

        return view('property.edit', [
            'property' => $property, 
            'property_id' => $id,
            'communities' => $communities
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property) {
          
        $property = Property::find($request->input('id'));
        $property->address_1 = $request->input('address_1');
        $property->address_2 = $request->input('address_2');
        $property->city = $request->input('city');
        $property->state = $request->input('state');
        $property->zip = $request->input('zip');
        $property->country = $request->input('country');
        $property->occupied = $request->input('occupied');
        $property->lease_length = $request->input('lease_length');
        $property->rent_amount = $request->input('rent_amount');
        $property->pet = $request->input('pet');
        $property->deposit_amount = $request->input('deposit_amount');
        $property->pet_deposit_amount = $request->input('pet_deposit_amount');
        $property->amount_refundable = $request->input('amount_refundable');
        $property->bed_amount = $request->input('bed_amount');
        $property->bath_amount = $request->input('bath_amount');
        $property->square_footage = $request->input('square_footage');
        $property->description = $request->input('description');
        $property->account_number = $request->input('account_number');
        $property->hoa_amount = $request->input('hoa_amount');
        $property->community_id = $request->input('community_id');
        
        $property->save();

        return redirect()
                ->route('property.index')
                ->with('info', 'Good job! Your property was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $property = Property::find($id);
        $property->delete();
        return redirect()
            ->route('property.index')
            ->with('info', 'Your property was successfully deleted');

    }
}
