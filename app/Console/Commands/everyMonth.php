<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class everyMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every month reset all rent values in the paid column';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        /**
         * TO UNDERSTAND WHAT THIS IS MEANT TO DO
         * Once a month, we need to look for all values in the Rents table under the Paid column that have been paid
         * We need to update those values to = 0 to reset it. Thus, this month's rent has not been paid.
        */

        $isPaid = DB::table('rents')->where('paid', 1)->update(['paid' => 0]);

        /**
         * Mark all the isPastDue's to past due if the payment is past the 15th
         * 
         * if the dates are inbetween the 15th and the 1st then update it as late (need to figure out how to pass variable to indicate late date for user)
         * 
         * and if the status is not paid 
         */

        $isLate = DB::table('rents')->where('isPastDue', 0)->update(['paid' => 1]);

        if( Carbon::now()->gte(15) && Carbon::now()->lte(1) ) {

        }

        $isLate = DB::table('rents')->where('isPastDue', 0)->update(['paid' => 1]);

        echo "we updated the paid values";

    }
}
