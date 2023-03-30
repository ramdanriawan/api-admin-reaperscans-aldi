@extends('layouts.app')


@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">User</h4>
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javaScript:void();">Halaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User</li>
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
                                                <th>Full Name</th>
                                                <th>Jenis Kelamin</th>
                                                <th>No Hp</th>
                                                <th>Email</th>
                                                <th>Level</th>
                                                <th>Alamat</th>
                                                <th>Foto Profile</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $item)
                                                <tr data-id='{{ $item->id }}'>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>{{ $item->fullName }}</td>
                                                    <td>{{ $item->jenisKelamin }}</td>
                                                    <td>{{ $item->noHp }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->level }}</td>
                                                    <td>{{ $item->alamat }}</td>
                                                    <td>
                                                        @if ($item->fotoProfile)
                                                            <a href="{{ url($item->fotoProfile) }}">
                                                                <img src="{{ url($item->fotoProfile) }}" width="50"
                                                                    height="50">
                                                            </a>
                                                        @elseif($item->googlePhotoUrl)
                                                            <a href="{{ url($item->googlePhotoUrl) }}">
                                                                <img src="{{ url($item->googlePhotoUrl) }}" width="50"
                                                                    height="50">
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($item->level != 'Admin')
                                                            @if (!$item->user_premium || $item->user_premium->status == 'Tidak Aktif')
                                                                <a
                                                                    href="{{ url('/user' . '/' . $item->id . '/premiumkan') }}">
                                                                    Premiumkan
                                                                </a>
                                                            @endif

                                                            <form action="{{ url('/user' . '/' . $item->id) }}"
                                                                method='post' style='display: inline;'
                                                                onsubmit="return confirm('Yakin akan menghapus data ini?')">
                                                                @method('DELETE')
                                                                @csrf
                                                                <label class="label label-danger" href=""
                                                                    for='btnSubmit-{{ $item->id }}'
                                                                    style='cursor: pointer;'>Hapus</label>
                                                                <button type="submit" id='btnSubmit-{{ $item->id }}'
                                                                    style="display: none;"></button>
                                                            </form>
                                                        @endif
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
        const locationHrefHapusSemua = "{{ url('user/hapus_semua') }}";
        const locationHrefAktifkanSemua = "{{ url('user/aktifkan_semua') }}";
        const locationHrefCreate = "{{ url('user/create') }}";
        var columnOrders = [{{ $user_count - 4 }}];
        var urlSearch = "{{ url('user') }}";
        var q = "{{ $_GET['q'] ?? '' }}";
        var placeholder = "Filter...";
        var tampilkan_buttons = false;
        var button_manual = false;
    </script>
@endsection
