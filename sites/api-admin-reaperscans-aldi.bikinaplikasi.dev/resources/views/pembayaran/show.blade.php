@extends('layouts.app')
@section('content')
    <table class="table" id='dataTable'>
        <thead>
            <tr>
                <th>Nama</th>
                <th>No Hp</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <tr data-id='{{ $pembayaran->id }}'>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->no_hp }}</td>
                <td>{{ $item->alamat }}</td>
            </tr>
        </tbody>
    </table>
@endsection
