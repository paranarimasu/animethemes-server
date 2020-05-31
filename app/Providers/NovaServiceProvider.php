<?php

namespace App\Providers;

use App\Http\Controllers\Auth\NovaLoginController;
use App\Http\Controllers\Auth\NovaResetPasswordController;
use App\Nova\Metrics\NewAnime;
use App\Nova\Metrics\NewArtists;
use App\Nova\Metrics\NewSeries;
use App\Nova\Metrics\NewVideos;
use App\Nova\Metrics\AnimePerDay;
use App\Nova\Metrics\ArtistsPerDay;
use App\Nova\Metrics\SeriesPerDay;
use App\Nova\Metrics\VideosPerDay;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Http\Controllers\LoginController;
use Laravel\Nova\Http\Controllers\ResetPasswordController;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            // We are only granting accounts for nova access
            // We will check that the user has a role intended for nova
            return $user->isReadOnly() || $user->isContributor() || $user->isAdmin();
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new NewVideos)->width('1/4'),
            (new NewAnime)->width('1/4'),
            (new NewArtists)->width('1/4'),
            (new NewSeries)->width('1/4'),

            (new VideosPerDay)->width('1/4'),
            (new AnimePerDay)->width('1/4'),
            (new ArtistsPerDay)->width('1/4'),
            (new SeriesPerDay)->width('1/4'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoginController::class, NovaLoginController::class);
        $this->app->bind(ResetPasswordController::class, NovaResetPasswordController::class);
    }
}
