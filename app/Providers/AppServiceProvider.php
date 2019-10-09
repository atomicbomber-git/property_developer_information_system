<?php

namespace App\Providers;

use App\Enums\EntityType;
use App\Helpers\Formatter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('convert_money', function ($money) {
            return "<?php echo number_format($money, 0, ',', '.'); ?>";
        });

        Blade::directive('format_date', function ($date) {
            return "<?php echo (new Date($date))->format('j F Y'); ?>";
        });
    }

    public function register()
    {
        $this->registerEloquentMorphMap();
        $this->registerFormatterHelper();
    }

    private function registerEloquentMorphMap()
    {
        Relation::morphMap([
            EntityType::VENDOR => \App\Vendor::class,
            EntityType::STORAGE => \App\Storage::class,
            EntityType::DELIVERY_ORDER_ITEM => \App\DeliveryOrderItem::class,
            EntityType::STOCK_ADJUSTMENT => \App\StockAdjustment::class,
        ]);
    }

    private function registerFormatterHelper()
    {
        $this->app->singleton(Formatter::class, function ($app) {
            return new Formatter;
        });
    }
}
