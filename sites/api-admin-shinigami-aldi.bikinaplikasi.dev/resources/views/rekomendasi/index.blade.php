@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">rekomendasi</h4>
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javaScript:void();">Halaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">rekomendasi</li>
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

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <a href='{{ url("rekomendasi/create") }}' class="btn btn-success">Update</a>
                                        </div>
                                    </div>

                                    <table class="table" id='dataTable'>
                                        <thead>
                                            <tr>
                                                <th width=2>#</th>
                                                <th>Komik</th>
                                                <th>rekomendasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rekomendasi as $item)
                                                <tr data-id='{{ $item->id }}'>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>{{ $item->komik->judul }}</td>
                                                    <td>{{ $item->rekomendasi }}</td>
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
        const locationHrefHapusSemua = "{{ url('rekomendasi/hapus_semua') }}";
        const locationHrefAktifkanSemua = "{{ url('rekomendasi/aktifkan_semua') }}";
        const locationHrefCreate = "{{ url('rekomendasi/create') }}";
        var columnOrders = [0];
        var urlSearch = "{{ url('rekomendasi') }}";
        var q = "{{ $_GET['q'] ?? '' }}";
        var placeholder = "Filter...";
        var tampilkan_buttons = false;
        var button_manual = false;
    </script>
@endsection
