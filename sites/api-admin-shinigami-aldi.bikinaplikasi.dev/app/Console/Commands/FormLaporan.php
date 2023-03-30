<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FormLaporan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formlaporan:make {tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk membuat form laporan sebelum diprint';

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
            foreach(DB::select("DESC $table") as $tableField)
            {
                $fields[] = $tableField->Field;
            }

            $fields = array_map(function($field){
                return "'$field'";
            }, $fields);

            $fields = "[" . implode(",", $fields) . "]";

            $limit = DB::table($table)->get()->count();

            $form = <<<EOD
            <div class='row'>
                <div class='col-md-6'>
                <form class="form-horizontal form-material" action="{{ url(route('$table.print')) }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Field</label>
                    <div class="col-md-12">
                        <select class="form-control form-control-line" name='field'  required>
                            @foreach($fields as \$field)
                            <option value="{{ \$field }}" @if(old('field')==\$field)
                                selected @endif>{{ ucwords(preg_replace("/_/", " ", \$field)) }}</option>
                            @endforeach
                        </select>
                        @error('field')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ \$message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Order</label>
                    <div class="col-md-12">
                        <select class="form-control form-control-line" name='order'  required>
                            @foreach(['ASC', 'DESC'] as \$order)
                            <option value="{{ \$order }}" @if(old('order')==\$order)
                                selected @endif>{{ \$order }}</option>
                            @endforeach
                        </select>
                        @error('order')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ \$message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Limit</label>
                    <div class="col-md-12">
                        <input type="number" placeholder="{{ \$limit }}"
                            class="form-control form-control-line" id="example-limit"
                            value='{{ old('limit') == "" ? \$limit : old('limit') }}' name='limit' max='{{ \$limit }}' min=1 required>
                        @error('limit')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ \$message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button name='preview' value='true' class="btn btn-info" type="submit">Preview</button>
                        <button class="btn btn-primary" type="submit">Print Html</button>
                        <button name='print_excel' value='true'  class="btn btn-success" type="submit">Print Excel</button>
                    </div>
                </div>
            </form>
            </div>
            </div>
            EOD;

            $laporanIndex = <<< EOD
                @extends('layouts.app')
                @section('content')
                @include('layouts.$table.laporan.index')
                @endsection
            EOD;

            @mkdir(base_path("resources/views/$table/laporan"), 0777, true);

            file_put_contents(base_path("resources/views/$table/laporan/index.blade.php"), $laporanIndex);

            @mkdir(base_path("resources/views/layouts/$table/laporan"), 0777, true);

            file_put_contents(base_path("resources/views/layouts/$table/laporan/index.blade.php"), $form);

            echo "Berhasil diletakkan di" . base_path("resources/views/layouts/$table/laporan/index.blade.php");
        }
    }
}
