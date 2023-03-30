@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">popup</h4>
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javaScript:void();">Halaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">popup</li>
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
                                                <th>Link</th>
                                                <th>Gambar</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($popup as $item)
                                                <tr data-id='{{ $item->id }}'>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>{{ $item->link }}</td>

                                                    <td>
                                                        <a class="btn btn-sm btn-primary-outline"
                                                            href="{{ url($item->gambar) }}">
                                                            <img src="{{ url($item->gambar) }}" width="100"
                                                                height="100">
                                                        </a>
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($item->status != 'Aktif')
                                                            <a class="label label-primary"
                                                                href="{{ url('/popup/' . $item->id . '/aktifkan') }}">Aktifkan</a>
                                                        @endif

                                                        <a class="label label-primary"
                                                            href="{{ url('/popup/' . $item->id . '/edit') }}">Edit</a>

                                                        <form action="{{ url('/popup' . '/' . $item->id) }}" method='post'
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
        const locationHrefHapusSemua = "{{ url('popup/hapus_semua') }}";
        const locationHrefAktifkanSemua = "{{ url('popup/aktifkan_semua') }}";
        const locationHrefCreate = "{{ url('popup/create') }}";
        var columnOrders = [{{ $popup_count - 4 }}];
        var urlSearch = "{{ url('popup') }}";
        var q = "{{ $_GET['q'] ?? '' }}";
        var placeholder = "Filter...";
        var tampilkan_buttons = true;
        var button_manual = true;
    </script>
@endsection
