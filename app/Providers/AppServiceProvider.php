<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Blade;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config([
            'global' => Setting::all([
                'name','value'
            ])->keyBy('name')->transform(function ($setting) {
                return $setting->value;
            })->toArray()

        ]);

        Blade::directive('rupiah', function ( $expression ) { return "Rp. <?php echo number_format($expression,0,',','.'); ?>"; });

    }
}
