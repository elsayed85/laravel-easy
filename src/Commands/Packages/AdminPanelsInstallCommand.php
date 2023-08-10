<?php

namespace Elsayed85\LaravelEasy\Commands\Packages;

use Elsayed85\LaravelEasy\Commands\Packages\Filament\InstallFilamentCommand;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

class AdminPanelsInstallCommand extends Command
{
    public $signature = 'easy:admin:install';

    public $description = 'Install Admin Panels';

    public function handle(): int
    {
        $panel = select(
            label: 'Which Admin Panel do you want to install ?',
            options: ['filament'],
            default: 'filament'
        );

        $command = match ($panel) {
            'filament' => InstallFilamentCommand::class,
        };

        if ($command) {
            $this->call($command);

            return self::SUCCESS;
        }

        return self::FAILURE;
    }
}
