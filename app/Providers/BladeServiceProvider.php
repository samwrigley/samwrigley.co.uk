<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->addDateBladeDirective();
    }

    /**
     * Format given string instance into a date string.
     *
     * @example @date($value)
     * @return void
     */
    private function addDateBladeDirective(): void
    {
        Blade::directive('date', static function (string $date): string {
            return "<?php echo (${date})->format('jS F Y'); ?>";
        });
    }
}
