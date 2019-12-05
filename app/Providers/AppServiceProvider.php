<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use Blade;

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
        Schema::defaultStringLength(191);
        Passport::routes();

        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2, ',', ' '); ?>";
        });

        Blade::directive('formatDate', function ($date) {
        
            return "<?php echo date_format($date,'d-m-Y').' '.' à'.' '.date_format($date,'H:i:s');  ?>";
        });

       

    }
}
