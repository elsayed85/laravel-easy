<?php

namespace Elsayed85\LaravelEasy\Commands\Modules;

use Elsayed85\LaravelEasy\Commands\Command;
use function Laravel\Prompts\text;

class CreateModuleCommand extends Command
{
    public $signature = 'easy:module:create';

    public $description = 'Create New Module';

    public function handle(): int
    {
        $name = text(
            label: 'Enter Module Name',
            placeholder: 'Agent',
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 2 => 'The name must be at least 2 characters.',
                strlen($value) > 40 => 'The name must not exceed 40 characters.',
                default => null
            }
        );

        $this->makeModel($name);

        return self::SUCCESS;
    }

    private function makeModel(string $name)
    {
        $this->call('make:model', ['name' => $name]);
    }
}
