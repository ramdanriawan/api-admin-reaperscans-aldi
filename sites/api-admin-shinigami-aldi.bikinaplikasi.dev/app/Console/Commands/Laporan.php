<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Laporan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laporan:make {tableIgnore}';
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

            if (in_array($value, $tableIgnore)) {

                continue;
            }

            $laporan = "@if(in_array(auth()->user()->level, ['Admin', 'Karyawan']))
                <li>
                    <a @if(Route::current()->action['as'] == '$value.index') class='active-menu'
                       @endif href=\"{{ route('$value.index') }}\"><i class=\"zmdi zmdi-long-arrow-right\"></i> $value</a>
                </li>
            @endif";

            file_put_contents(base_path('resources/views/layouts/laporan.blade.php'), $laporan);
        }


        echo "Berhasil diletakkan di" . base_path('resources/views/layouts/laporan.blade.php');
    }
}
