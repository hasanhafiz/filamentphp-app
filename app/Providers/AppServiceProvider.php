<?php

namespace App\Providers;

use Filament\Tables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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

        Gate::before(function ($user, $ability) {
            if ($user->id == 11)
                return true;
        });

        Tables\Actions\CreateAction::configureUsing(function ($action) {
            return $action->slideOver();
        });

        Tables\Actions\EditAction::configureUsing(function ($action) {
            return $action->slideOver();
        });
    }
}
