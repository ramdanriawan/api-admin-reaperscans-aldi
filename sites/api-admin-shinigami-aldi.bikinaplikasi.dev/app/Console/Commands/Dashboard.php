<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Dashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:make {tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dashboard make';

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
     * @return int
     */
    public function handle()
    {
        $tables = DB::select('SHOW TABLES');

        $dashboard = "";
        foreach ($tables as $table) {
            foreach ($table as $key => $value)

                $tables = explode(',', $this->argument('tables'));

            if (!in_array($value, $tables)) {

                continue;
            }

            $dashboard .= "
                <div class=\"col-12 col-lg-6 col-xl-3\">
                    <div class=\"card gradient-deepblue\">
                        <div class=\"card-body\">
                            <h5 class=\"text-white mb-0\">{{ \${$value}s->count() }} <span class=\"float-right\"><i
                                        class=\"fa fa-shopping-cart\"></i></span></h5>
                            <div class=\"progress my-3\" style=\"height:3px;\">
                                <div class=\"progress-bar\" style=\"width:55%\"></div>
                            </div>
                            <p class=\"mb-0 text-white small-font\">Total $value<span class=\"float-right\">+{{ \${$value}s->count() }} <i
                                        class=\"zmdi zmdi-long-arrow-up\"></i></span></p>
                        </div>
                    </div>
                </div>
            ";
        }

        file_put_contents(base_path('resources/views/layouts/dashboard.blade.php'), $dashboard);

        echo "Berhasil diletakkan di" . base_path('resources/views/layouts/dashboard.blade.php');
    }
}
