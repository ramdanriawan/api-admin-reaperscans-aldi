@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'user.index') class='active-menu'
           @endif href="{{ route('user.index') }}"><i class="fa fa-table"></i>User</a>
    </li>
@endif
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'komik.index') class='active-menu'
           @endif href="{{ route('komik.index') }}"><i class="fa fa-table"></i>Komik</a>
    </li>
@endif
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'ranking.index') class='active-menu'
           @endif href="{{ route('ranking.index') }}"><i class="fa fa-table"></i>Ranking</a>
    </li>
@endif
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'rekomendasi.index') class='active-menu'
           @endif href="{{ route('rekomendasi.index') }}"><i class="fa fa-table"></i>Rekomendasi</a>
    </li>
@endif
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'slider.index') class='active-menu'
           @endif href="{{ route('slider.index') }}"><i class="fa fa-table"></i>Slider</a>
    </li>
@endif
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'genre.index') class='active-menu'
           @endif href="{{ route('genre.index') }}"><i class="fa fa-table"></i>Genre</a>
    </li>
@endif
{{-- @if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'tipe.index') class='active-menu'
           @endif href="{{ route('tipe.index') }}"><i class="fa fa-table"></i>Tipe</a>
    </li>
@endif --}}
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'pembayaran.index') class='active-menu'
           @endif href="{{ route('pembayaran.index') }}"><i class="fa fa-table"></i>Pembayaran</a>
    </li>
@endif
@if(in_array(auth()->user()->level, ['Admin']))
    <li>
        <a @if(Route::current()->action['as'] == 'popup.index') class='active-menu'
           @endif href="{{ route('popup.index') }}"><i class="fa fa-table"></i>Popup</a>
    </li>
@endif
