@extends('layouts.app')


@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">Chapter</h4>
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javaScript:void();">Halaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chapter</li>
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
                                <form class="form-horizontal form-material" action="{{ url('/chapter/importStore') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="komik_id" value="{{ request()->komik_id }}">

                                    <div class="form-group {{ $errors->has('file_zip') ? 'has-error' : '' }}">
                                        <label for="file_zip" class="control-label">{{ 'File Zip' }}</label>

                                        <div class="col-md-12">
                                            <input placeholder="file_zip"
                                                class="form-control form-control-line @error('file_zip') is-invalid @enderror"
                                                name="file_zip" type="file" id="file_zip"
                                                value="{{ isset($chapter->file_zip) ? $chapter->file_zip : old('file_zip') }}" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">

                                            @error('file_zip')
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
