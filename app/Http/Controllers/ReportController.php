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
use Carbon\Carbon;
use Illuminate\Support\Collection;
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

                $months = $data->pluck('created_at')->map->format('m')->unique();  
                $months->all();
  
                $total = 0;
                $dataset = array("0");

                foreach($months as $month) {

                    $year = Carbon::now()->year;

                    $monthSum = Property::join('transactions', 'transactions.property_id', '=', 'properties.id')
                                ->where('properties.company_id', '=', Auth::user()->company_id)
                                ->whereMonth('transactions.created_at', '=', $month)
                                ->sum('amount_paid');


                    // $dataset[$year][$label] = array(
                    //     "label" => $label,
                    //     "total" => $monthSum,
                    // );

                    array_push($dataset, $monthSum);
                }
                
                foreach($data as $d) {

                    // total the number of earnings
                    $total += $d->amount_paid;

                    // format the dates
                    $year = $d->created_at->format('Y');
                    $month = $d->created_at->format('M');
                    
                }
                
                //$no_duplicates = array_unique($dataset);

                return view('reports.revenue', [
                    'data' => $data, 
                    'dataset' => json_encode($dataset, JSON_PRETTY_PRINT),
                    'total' => $total,
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
