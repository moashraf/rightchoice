<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        // Load helper functions
        if (file_exists(app_path('help/helper.php'))) {
            require_once app_path('help/helper.php');
        }
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

        // ── RBAC Blade Directives ────────────────────────────────────────────
        // @role('admin') ... @endrole
        // Shows content only to users with a specific role.
        Blade::directive('role', function (string $expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });
        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });

        // @haspermission('users.create') ... @endhaspermission
        // Shows content only when the current user has the given permission.
        Blade::directive('haspermission', function (string $expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission({$expression})): ?>";
        });
        Blade::directive('endhaspermission', function () {
            return '<?php endif; ?>';
        });

        // @cannotdo('users.delete') ... @endcannotdo
        // Shows content (e.g. disabled button / warning) when user LACKS a permission.
        Blade::directive('cannotdo', function (string $expression) {
            return "<?php if(!auth()->check() || !auth()->user()->hasPermission({$expression})): ?>";
        });
        Blade::directive('endcannotdo', function () {
            return '<?php endif; ?>';
        });

        // @vieweronly ... @endvieweronly
        // Shows content only for read-only viewer role.
        Blade::directive('vieweronly', function () {
            return "<?php if(auth()->check() && auth()->user()->canViewOnly()): ?>";
        });
        Blade::directive('endvieweronly', function () {
            return '<?php endif; ?>';
        });

    }
}
