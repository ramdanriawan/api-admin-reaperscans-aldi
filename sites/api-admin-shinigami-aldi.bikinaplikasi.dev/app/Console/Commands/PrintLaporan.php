<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrintLaporan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printlaporan:make {tables} {columnIgnores}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk print laporan';

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
        $tables = explode(',', $this->argument('tables'));

        foreach ($tables as $key => $table) {

            $fields = [];
            $rows = [];
            foreach(DB::select("DESC $table") as $tableField)
            {
                if(in_array($tableField->Field, explode(',', $this->argument('columnIgnores')))) {

                    continue;
                }

                $fields[] = ucwords(preg_replace("/_/", " ", $tableField->Field));
                $rows[] = "<td>{{ \${$table}->{$tableField->Field} }}</td>\n";
            }

            $fields = array_map(function($field){
                return "<th>$field</th>\r";
            }, $fields);

            $rows = array_map(function($row){
                return "$row\r";
            }, $rows);

            $fields = implode("", $fields);
            $rows = implode("", $rows);

            $tableUppercase = preg_replace("/_/", " ", strtoupper($table));

            $laporanPrint = <<< EOD
                @extends('layouts.print')
                @section('content')
                    <h3 align="center">LAPORAN $tableUppercase</h3>
                    <table width="100%" border="1" style='margin-bottom: 250px;'>
                <thead>
                    <tr>
                        <th width=3>No.</th>
                        $fields
                    </tr>
                </thead>
                <tbody>
                    @foreach(\${$table}s as \${$table})
                    <tr>
                        <th>{{ \$loop->iteration }}.</th>
                        $rows
                    </tr>
                    @endforeach
                </tbody>
                </table>
                @endsection
            EOD;

            @mkdir(base_path("resources/views/$table/laporan"), 0777, true);
            file_put_contents(base_path("resources/views/$table/laporan/print.blade.php"), $laporanPrint);

            echo "Berhasil diletakkan di" . base_path("resources/views/layouts/$table/laporan/print.blade.php");
        }
    }
}