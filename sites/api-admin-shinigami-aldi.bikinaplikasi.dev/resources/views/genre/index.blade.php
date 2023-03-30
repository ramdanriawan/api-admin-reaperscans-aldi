@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">Komik</h4>
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javaScript:void();">Halaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Komik</li>
                    </ol>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div class="card px-1">
                            <div class="card-body">
                                @if (session()->has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session()->get('error') }}
                                    </div>
                                @elseif(session()->has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session()->get('success') }}
                                    </div>
                                @elseif(session()->has('warning'))
                                    <div class="alert alert-warning" role="alert">
                                        {{ session()->get('warning') }}
                                    </div>
                                @endif

                                <div class="table-stats order-table ov-h table-responsive">

                                    <table class="table" id='dataTable'>
                                        <thead>
                                            <tr>
                                                <th width=2>#</th>
                                                <th>Nama</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($genre as $item)
                                                <tr data-id='{{ $item->id }}'>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>{{ $item->nama }}</td>


                                                    <td class="text-center">

                                                        <a class="label label-primary"
                                                            href="{{ url('/genre/' . $item->id . '/edit') }}">Edit</a>
                                                        <form action="{{ url('/genre' . '/' . $item->id) }}" method='post'
                                                            style='display: inline;'
                                                            onsubmit="return confirm('Yakin akan menghapus data ini?')">
                                                            @method('DELETE')
                                                            @csrf
                                                            <label class="label label-danger" href=""
                                                                for='btnSubmit-{{ $item->id }}'
                                                                style='cursor: pointer;'>Hapus</label>
                                                            <button type="submit" id='btnSubmit-{{ $item->id }}'
                                                                style="display: none;"></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script>
        const locationHrefHapusSemua = "{{ url('genre/hapus_semua') }}";
        const locationHrefAktifkanSemua = "{{ url('genre/aktifkan_semua') }}";
        const locationHrefCreate = "{{ url('genre/create') }}";
        var columnOrders = [0];
        var urlSearch = "{{ url('genre') }}";
        var q = "{{ $_GET['q'] ?? '' }}";
        var placeholder = "Filter...";
        var tampilkan_buttons = true;
        var button_manual = true;
    </script>
@endsection
