<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /*
         * Format given string instance into a date string.
         *
         * @example @date($value)
         */
        Blade::directive('date', function (string $date): string {
            return "<?php echo (${date})->format('jS F Y'); ?>";
        });
    }
}
