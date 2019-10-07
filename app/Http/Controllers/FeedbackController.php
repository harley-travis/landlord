<?php

namespace App\Http\Controllers;

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
        
        $feedbacks = Feedback::join('users', 'feedback.user_id', '=', 'users.id')
                        ->where('users.role', '=>', '4')
                        ->where('status','!=','3')
                        ->paginate(15);

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
        
        $feedback = Feedback::where('company_id', '=', Auth::user()->company_id)
        ->where('id', '=', $id)
        ->first();

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
}
