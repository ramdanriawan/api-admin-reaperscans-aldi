<?php

namespace App\Providers;

use App\Models\Disposisi;
use App\Models\Pesanan;
use App\Models\SuratMasuk;
use App\Models\Disukai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);
        
//        $notifs = Disukai::where('createdAt', "like", '%' . Carbon::today()->toDateString() . '%')->limit(10)->get();
        
//        \View::share('notifs', $notifs);
    }
}
