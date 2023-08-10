<?php

namespace Elsayed85\LaravelEasy\Commands\Packages\Filament;

use Elsayed85\LaravelEasy\Commands\Command;
use Elsayed85\LaravelEasy\Services\VendorPublish;

class InstallFilamentCommand extends Command
{
    public $signature = 'easy:filament:install';

    public $description = 'Install Filament Admin Panel';

    private string $repository = 'filament/filament';

    public function handle(): int
    {
        $this->handelInstall();
        $this->handelPublish();

        return self::SUCCESS;
    }

    private function handelInstall(): void
    {
        $this->process(
            command : $this->installWithComposer($this->repository),
            success: function () {
                $this->info($this->getProcessResult()->output());
                $this->info('Filament Admin Panel Installed Successfully');
            },
            fail : function () {
                $this->error($this->getProcessResult()->errorOutput());
                $this->error('Filament Admin Panel Install Failed');
            }
        );
    }

    private function handelPublish(): void
    {
        $publishCommand = (new VendorPublish())->tag('filament-config')->getFullCommand();
        $this->process(
            command : $publishCommand,
            success: function () {
                $this->info($this->getProcessResult()->output());
                $this->info('Filament Config File Published Successfully');
            },
            fail : function () {
                $this->error($this->getProcessResult()->errorOutput());
                $this->error('Filament Config File Publish Failed');
            }
        );
    }
}
