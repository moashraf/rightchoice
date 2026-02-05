<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

use App\Models\Service;

use App\Models\OfferTypes;
use App\Models\SettingSite;
use App\Models\Notification;

use Auth;

use View;

use Illuminate\Support\Facades\App;

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
        Paginator::useBootstrap();
   view()->composer('*', function ($view)
        {

        $thisUrl = url()->current().'/';
        if (App::isLocale('en')) {
            $newUrl  = str_replace('/en/', '/ar/', $thisUrl);

        }else if (App::isLocale('ar')) {
            $newUrl  = str_replace('/ar/', '/en/', $thisUrl);
        }
           $serviceInHeader = Service::all();
           $offersTypeForCashAndInstallment = OfferTypes::whereIn('id', [1,2])->get();
           $offersTypeForRents = OfferTypes::whereIn('id', [3,4])->get();

           $view->with('serviceInHeader', $serviceInHeader);
           $view->with('offersTypeForCashAndInstallment', $offersTypeForCashAndInstallment);
           $view->with('offersTypeForRents', $offersTypeForRents);



               if(Auth::check()){
                  $name = Auth::user()->name;
                  $splitName = explode(' ', $name, 2);
                  $first_name = $splitName[0];
                  $last_name = !empty($splitName[1]) ? $splitName[1] : '';
                  $view->with('first_name', $first_name);

                 $countNotifi = Notification::where('user_id',Auth::user()->id)->where('status',0)->count();

                    $view->with('countNotifi', $countNotifi);
               }

            $view->with('newUrl', $newUrl);


        });


    }
}
