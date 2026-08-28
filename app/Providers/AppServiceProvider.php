<?php

namespace App\Providers;

use App\View\Components\ListView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\View\PlanoFlexbilizacaoStatefulForm;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(\OwenIt\Auditing\Models\Audit::class, \App\Policies\AuditPolicy::class);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
