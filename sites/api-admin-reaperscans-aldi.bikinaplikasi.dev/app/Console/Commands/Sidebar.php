<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Sidebar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sidebar:make {tableIgnore}';
    // protected $signature = 'menu:sidebar {tableIgnore}  {laporanIgnore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat menu sidebar kiri';

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

        $tablesReturn = [];
        $laporanReturn = [];
        foreach ($tables as $table) {
            foreach ($table as $key => $value)

            $tableIgnore = explode(',', $this->argument('tableIgnore'));

            if(in_array($value, $tableIgnore)) {

                continue;
            }

            $valueCaptialize = ucwords(preg_replace('/_/', " ", $value));

            $tablesReturn[] = "

            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == '$value.index') class='active-menu' @endif href=\"{{ route('$value.index') }}\"><i class=\"fa fa-table\"></i>$valueCaptialize</a>
            </li>
            @endif
            \r";
        }

        file_put_contents(base_path('resources/views/layouts/sidebar.blade.php'), implode("", $tablesReturn));

        echo "Berhasil diletakkan di" . base_path('resources/views/layouts/sidebar.blade.php');
    }
}
