<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->addDateBladeDirective();
    }

    private function addDateBladeDirective(): void
    {
        Blade::directive('date', static function (string $date): string {
            return "<?php echo (${date})->format('jS F Y'); ?>";
        });
    }
}
