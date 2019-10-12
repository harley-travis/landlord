<?php

namespace App\Http\Controllers;

use Auth;
use App\Community;
use App\Company;
use Illuminate\Http\Request;

class CommunityController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $communities = Community::where('company_id', '=', Auth::user()->company_id)->paginate(15);
        $company = Company::where('id', '=', Auth::user()->company_id)->first();

        return view('community.index', ['communities' => $communities, 'company' => $company,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('community.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)  {
        
        $user = Auth::user();

        $community = new Community([
            'hoa_community' => $request->input('hoa_community'),
            'company_id' => $user->company_id,
        ]);
        $community->save();

        return redirect()
                ->route('community.index')
                ->with('info', 'Good job! Your community was saved successfully!');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $community = Community::find($id);
        return view('community.edit', ['community' => $community, 'id' => $id]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Community $community) {
        
        $community = Community::find($request->input('id'));
        $community->hoa_community = $request->input('hoa_community');
        $community->save();

        return redirect()
                ->route('community.index')
                ->with('info', 'Good job! Your community was updated successfully!');
    }

}
