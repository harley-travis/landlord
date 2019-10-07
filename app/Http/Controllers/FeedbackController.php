<?php

namespace App\Http\Controllers;

use DB;
use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $feedbacks = DB::table('feedback')->paginate(15);

        return view('feedback.index', ['feedbacks' => $feedbacks]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        $feedback = Feedback::find($id)->first();

        return view('feedback.show', ['feedback' => $feedback]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback) {

        $feedback = Feedback::find($request->input('id'));
        $feedback->status = $request->input('status');
        $feedback->save();

        return redirect()
                ->route('feedback.index')
                ->with('info', 'Good job! You successfully updated your feedback status!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback) {
        //
    }

    public function showArchive() {
        $requests = Maintenance::where('company_id', '=', Auth::user()->company_id)->where('status','=','3')->paginate(15);
        return view('maintenance.archive', ['requests' => $requests]);
    }

    public function archive($id) {
        $tenant = Tenant::find($id);
        $tenant->active = 0;
        $tenant->save();
        return redirect()->route('tenants.index')->with('info', 'The tenant was successfully archived');
    }

    public function progression(Request $request, $id) {
        
        $feedback = Feedback::find($id);
        $feedback->status = $request->status + 1;
        $feedback->save();

        return redirect()->route('feedback.index')->with('info', 'The feedback status was successfully updated!');

    }
}
