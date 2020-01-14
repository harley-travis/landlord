<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $feedbacks = User::join('feedback', 'feedback.user_id', '=', 'users.id')
                        ->where('feedback.status', '!=', '3')
                        ->orderBy('feedback.created_at', 'desc')
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

        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ]);
    
        $feedback = new Feedback([
            'subject' => $request->input('subject'),
            'description'=> $request->input('description'),
            'status'=> 0,
            'company_id' => $request->input('company_id'),
            'user_id' => $request->input('user_id'),
        ]);
        $feedback->save();

        return redirect()
                ->route('feedback.create')
                ->with('info', 'Thank you for your feedback! We always look at these with great care!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        $feedback = Feedback::where('id', '=', $id)->first();
        return view('feedback.show', ['feedback' => $feedback]);

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

    public function showArchive() {
        
        $feedbacks = DB::table('feedback')
                        ->where('status', '=', '3')
                        ->latest()
                        ->paginate(15);

        return view('feedback.archive', ['feedbacks' => $feedbacks]);
    }

    public function progression(Request $request, $id) {
        
        $feedback = Feedback::find($id);
        $feedback->status = $request->status + 1;
        $feedback->save();

        return redirect()->route('feedback.index')->with('info', 'The feedback status was successfully updated!');

    }
}
