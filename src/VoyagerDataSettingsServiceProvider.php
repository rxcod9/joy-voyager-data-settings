<?php

declare(strict_types=1);

namespace Joy\VoyagerDataSettings;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Joy\VoyagerDataSettings\Console\Commands\DataSettings;
use Joy\VoyagerDataSettings\Models\DataSetting;
use Joy\VoyagerDataSettings\Models\DataSettingType;
use Joy\VoyagerDataSettings\Policies\DataSettingPolicy;
use TCG\Voyager\Facades\Voyager;

/**
 * Class VoyagerDataSettingsServiceProvider
 *
 * @category  Package
 * @package   JoyVoyagerDataSettings
 * @author    Ramakant Gangwar <gangwar.ramakant@gmail.com>
 * @copyright 2021 Copyright (c) Ramakant Gangwar (https://github.com/rxcod9)
 * @license   http://github.com/rxcod9/joy-voyager-data-settings/blob/main/LICENSE New BSD License
 * @link      https://github.com/rxcod9/joy-voyager-data-settings
 */
class VoyagerDataSettingsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DataSetting::class => DataSettingPolicy::class,
    ];

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        Voyager::useModel('DataSettingType', DataSettingType::class);
        Voyager::useModel('DataSetting', DataSetting::class);

        Voyager::addAction(\Joy\VoyagerDataSettings\Actions\DataSettingsAction::class);

        $this->registerPublishables();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'joy-voyager-data-settings');

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'joy-voyager-data-settings');

        $this->loadAuth();
    }

    public function loadAuth()
    {
        // DataType Policies
        $this->registerPolicies();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix(config('joy-voyager-data-settings.route_prefix', 'api'))
            ->middleware('api')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/voyager-data-settings.php', 'joy-voyager-data-settings');

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    /**
     * Register publishables.
     *
     * @return void
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/voyager-data-settings.php' => config_path('joy-voyager-data-settings.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/joy-voyager-data-settings'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/joy-voyager-data-settings'),
        ], 'translations');
    }

    protected function registerCommands(): void
    {
        $this->app->singleton('command.joy.voyager.data-settings', function () {
            return new DataSettings();
        });

        $this->commands([
            'command.joy.voyager.data-settings',
        ]);
    }
}
