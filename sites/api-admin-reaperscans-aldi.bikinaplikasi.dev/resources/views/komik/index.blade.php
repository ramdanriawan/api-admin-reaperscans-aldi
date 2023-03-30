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
                                                <th>ID</th>
                                                <th>Tipe</th>
                                                <th>Genre</th>
                                                <th>Judul</th>
                                                <th>Sinopsis</th>
                                                <th>Alternatif</th>
                                                <th>Author</th>
                                                <th>Artist</th>
                                                <th>Gambar</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($komik as $item)
                                                <tr data-id='{{ $item->id }}'>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->komik_tipe ? $item->komik_tipe->nama : "" }}</td>
                                                    <td>{{ $item->komik_list_genres->pluck('komik_genre.nama')->join(',') }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->sinopsis }}</td>
                                                    <td>{{ $item->alternatif }}</td>
                                                    <td>{{ $item->author }}</td>
                                                    <td>{{ $item->artist }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary-outline"
                                                            href="{{ url($item->gambar) }}">
                                                            <img src="{{ url($item->gambar) }}" width="100"
                                                                height="100">
                                                        </a>
                                                    </td>

                                                    <td class="text-center">
                                                        <a class="label label-primary"
                                                            href="{{ url('/slider/create?komik_id=' . $item->id) }}">Jadikan Slider</a>
                                                        <a class="label label-primary"
                                                            href="{{ url('/chapter?komik_id=' . $item->id) }}">Chapter</a>

                                                        <a class="label label-primary"
                                                            href="{{ url('/komik/' . $item->id . '/edit') }}">Edit</a>

                                                        <form action="{{ url('/komik' . '/' . $item->id) }}" method='post'
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
        const locationHrefHapusSemua = "{{ url('komik/hapus_semua') }}";
        const locationHrefAktifkanSemua = "{{ url('komik/aktifkan_semua') }}";
        const locationHrefCreate = "{{ url('komik/create') }}";
        var columnOrders = [{{ $komik_count - 4 }}];
        var urlSearch = "{{ url('komik') }}";
        var q = "{{ $_GET['q'] ?? '' }}";
        var placeholder = "Filter...";
        var tampilkan_buttons = true;
        var button_manual = true;
    </script>
@endsection
