<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $tickets = User::join('tickets', 'tickets.user_id', '=', 'users.id')
                        ->where('tickets.status', '!=', '3')
                        ->orderBy('tickets.created_at', 'desc')
                        ->paginate(15);

        return view('tickets.index', ['tickets' => $tickets]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('tickets.create');
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
    
        $ticket = new Ticket([
            'subject' => $request->input('subject'),
            'description'=> $request->input('description'),
            'status'=> 0,
            'company_id' => $request->input('company_id'),
            'user_id' => $request->input('user_id'),
        ]);
        $ticket->save();

        return redirect()
                ->route('tickets.create')
                ->with('info', 'Thank you for submitting a ticket! We will get back with you within 24 hours.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        $ticket = Ticket::where('id', '=', $id)->first();
        return view('tickets.show', ['ticket' => $ticket]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket) {

        $ticket = Ticket::find($request->input('id'));
        $ticket->status = $request->input('status');
        $ticket->save();

        return redirect()
                ->route('tickets.index')
                ->with('info', 'Good job! You successfully updated your ticket status!');
    }

    public function showArchive() {
        
        $tickets = DB::table('tickets')
                        ->where('status', '=', '3')
                        ->latest()
                        ->paginate(15);

        return view('tickets.archive', ['tickets' => $tickets]);
    }

    public function progression(Request $request, $id) {
        
        $ticket = Ticket::find($id);
        $ticket->status = $request->status + 1;
        $ticket->save();

        return redirect()
                ->route('tickets.index')
                ->with('info', 'The ticket status was successfully updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
