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
                        <li class="breadcrumb-item active" aria-current="page">Premiumkan</li>
                    </ol>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-6">
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
                                <form class="form-horizontal form-material" action="{{ url('/user/premiumkanStore') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="user_id" value="{{ $user_id}}">

                                    <div class="form-group {{ $errors->has('jumlah_bulan') ? 'has-error' : '' }}">
                                        <label for="jumlah_bulan" class="control-label">{{ 'Jumlah Bulan' }}</label>

                                        <div class="col-md-12">
                                            <input placeholder="jumlah_bulan"
                                                class="form-control form-control-line @error('jumlah_bulan') is-invalid @enderror"
                                                name="jumlah_bulan" type="text" id="jumlah_bulan"
                                                value="{{ old('jumlah_bulan') }}"
                                                required>

                                            @error('jumlah_bulan')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit">Simpan</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
