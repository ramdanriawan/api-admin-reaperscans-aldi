<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Chart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chart:make {tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $dataTables = [];
        $warnas     = ['#aad360', '#dac197', '#fff9d6', '#aad380', '#193d5a', '#f88600', '#ff9c98', '#aad356', '#facdab', '#aad350'];

        foreach ($tables as $key => $table) {
            foreach ($table as $value) {
                $tables = explode(',', $this->argument('tables'));

                if (!in_array($value, $tables)) {

                    continue;
                }

                $judul = ucwords(preg_replace("/_/", " ", $value));
                $dataTables[] = "['$judul', {{ \${$value}s->count() }}, '$warnas[$key]']";
            }
        }

        $appName    = env('APP_NAME');
        $dataTables = implode(",", $dataTables);

        $chart = <<<EOD
        var data = google.visualization.arrayToDataTable([
            ['$appName', 'Total', { role: 'style' }],

            $dataTables
        ]);

        var options = {
          title : '$appName',
          vAxis: {title: 'Total'},
          hAxis: {title: ''},
          seriesType: 'bars',
          series: {6: {type: 'line'}}
        };
EOD;

        file_put_contents(base_path('resources/views/layouts/chart.blade.php'), $chart);

        echo "Berhasil diletakkan di" . base_path('resources/views/layouts/chart.blade.php');
    }
}
