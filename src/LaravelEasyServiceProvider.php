<?php

namespace Elsayed85\LaravelEasy;

use Elsayed85\LaravelEasy\Commands\Make\MakeCrudCommand;
use Elsayed85\LaravelEasy\Commands\Packages\AdminPanelsInstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelEasyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-easy')
            ->hasConfigFile('laravel-easy')
            ->hasCommands([
                AdminPanelsInstallCommand::class,
                MakeCrudCommand::class,
            ]);
    }
}
