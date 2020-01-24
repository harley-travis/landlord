<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Property;
use App\Rent;
use App\Transaction;
use App\Maintenance;
use App\Company;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  {
        return view('reports.index');
    }

    public function show(Request $request) {

        // determine what the entry was
        $report = $request->input('report');

        switch($report) {
            case 0:

                // vacancies and occupancies
                $data = Property::where('company_id', '=', Auth::user()->company_id)->get();

                return view('reports.vacancies-and-occupancies', [
                    'data' => $data, 
                ]);

            break;
            case 1:

                // revenue
                $data = Property::join('transactions', 'transactions.property_id', '=', 'properties.id')
                    ->where('properties.company_id', '=', Auth::user()->company_id)
                    ->get();

                return view('reports.revenue', [
                    'data' => $data, 
                ]);

            break;
            case 2:

                // Maintenance request
                $data = Maintenance::where('company_id', '=', Auth::user()->company_id)->get();

                return view('reports.maintenance-requests', [
                    'data' => $data, 
                ]);

            break;
        }


        // grab the data

        // TO DO - EXPORT REPORTS INTO EXCEL

        // return the view

    }

}
