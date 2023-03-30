@if(in_array(auth()->user()->level, ['Admin', 'Karyawan']))
                <li>
                    <a @if(Route::current()->action['as'] == 'disukai.index') class='active-menu'
                       @endif href="{{ route('disukai.index') }}"><i class="zmdi zmdi-long-arrow-right"></i> disukai</a>
                </li>
            @endif