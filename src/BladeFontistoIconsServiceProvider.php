<?php

declare(strict_types=1);

namespace Codeat3\BladeFontistoIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeFontistoIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-fontisto-icons', []);

            $factory->add('fontisto-icons', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-fontisto-icons.php', 'blade-fontisto-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-fontisto-icons'),
            ], 'blade-fontisto-icons');

            $this->publishes([
                __DIR__ . '/../config/blade-fontisto-icons.php' => $this->app->configPath('blade-fontisto-icons.php'),
            ], 'blade-fontisto-icons-config');
        }
    }
}
