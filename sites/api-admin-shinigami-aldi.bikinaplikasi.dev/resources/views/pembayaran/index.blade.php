@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">Pembayaran</h4>
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javaScript:void();">Halaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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
                                                <th>User</th>
                                                <th>No Invoice</th>
                                                <th>Reference</th>
                                                <th>Waktu Bayar</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Jumlah Bulan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pembayaran as $item)
                                                <tr data-id='{{ $item->id }}'>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>
                                                        <a class="label label-primary"
                                                            href="{{ url('/user/' . $item->user_id) }}">{{ $item->user->fullName }}</a>
                                                    </td>
                                                    <td>{{ $item->no_invoice }}</td>
                                                    <td>{{ $item->reference }}</td>
                                                    <td>{{ $item->waktu_bayar }}</td>
                                                    <td>{{ toIdr($item->jumlah) }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <td>{{ $item->jumlah_bulan }}</td>

                                                    <td class="text-center">

                                                            <a class="label label-primary"
                                                            href="{{ url('/pembayaran/' . $item->id . '/edit') }}">Edit</a>
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
        const locationHrefHapusSemua = "{{ url('pembayaran/hapus_semua') }}";
        const locationHrefAktifkanSemua = "{{ url('pembayaran/aktifkan_semua') }}";
        const locationHrefCreate = "{{ url('pembayaran/create') }}";
        var columnOrders = [{{ $pembayaran_count - 4 }}];
        var urlSearch = "{{ url('pembayaran') }}";
        var q = "{{ $_GET['q'] ?? '' }}";
        var placeholder = "Filter...";
        var tampilkan_buttons = true;
        var button_manual = true;
    </script>
@endsection
