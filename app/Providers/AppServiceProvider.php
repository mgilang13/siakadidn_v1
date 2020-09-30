<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        
        view()->composer('*', function ($view) {
            if(Auth::check()) {
                $id = Auth::user()->id;
                $notifMuhafidz = DB::select('call tahfidz_notifmuhafidz(?)', array($id));

                $view->with('notifMuhafidz', $notifMuhafidz);
            }
        });
        
    }
}
