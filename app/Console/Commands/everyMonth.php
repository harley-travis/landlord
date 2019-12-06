<?php

namespace App\Console\Commands;

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
         * Once a month, we need to look for all values in the Rents tablee under the Paid column that have been paid
         * We need to update those values to = 0 to reset it. Thus, this month's rent has not been paid.
        */

        $isPaid = DB::table('rents')->where('paid', 1)->update(['paid' => 0]);
        echo "we updated the paid values";

    }
}
