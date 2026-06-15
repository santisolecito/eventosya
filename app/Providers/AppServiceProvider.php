<?php
namespace App\Providers;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Builder::defaultStringLength(191);
        
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
