<?php

namespace App\Providers;

use App\Enums\EntityType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            EntityType::VENDOR => \App\Vendor::class,
            EntityType::STORAGE => \App\Storage::class
        ]);

        Blade::directive('convert_money', function ($money) {
            return "<?php echo number_format($money, 0, ',', '.'); ?>";
        });

        Blade::directive('format_date', function ($date) {
            return "<?php echo (new Date($date))->format('j F Y'); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
