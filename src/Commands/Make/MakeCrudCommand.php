<?php

namespace Elsayed85\LaravelEasy\Commands\Make;

use Elsayed85\LaravelEasy\Commands\Command;
use Elsayed85\LaravelEasy\Facades\File;
use Elsayed85\LaravelEasy\Traits\HasStubs;
use Illuminate\Filesystem\Filesystem;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class MakeCrudCommand extends Command
{
    use HasStubs;

    public $signature = 'easy:make:crud';

    public $description = 'Create New Crud';

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle(): int
    {
        $name = text(
            label: 'Enter the name of the model',
            placeholder: 'Agent',
            default : 'Elsayed',
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 2 => 'The name must be at least 2 characters.',
                strlen($value) > 40 => 'The name must not exceed 40 characters.',
                default => null
            },
        );

        $this->info('hint: use space to select multiple options');

        $options = multiselect(
            label: 'What  do you want to create?',
            options: [
                'model' => 'Model',
                'migration' => 'Migration',
                'controller' => 'Controller',
                'request' => 'Request',
                'view' => 'View',
                'service' => 'Service',
                'repository' => 'Repository',
                'seeder' => 'Seeder',
                'factory' => 'Factory',
            ],
            default: [
                'model',
                'seeder',
                'factory',
            ],
            scroll: 10,
        );

        $this->generateBasedOnSelectedOptions($options, $name);

        return self::SUCCESS;
    }

    public function generateBasedOnSelectedOptions(array $options, string $name): void
    {
        $nameUpper = ucfirst($name);
        $nameLower = strtolower($name);

        foreach ($options as $option) {
            match ($option) {
                'model' => $this->makeModel($nameUpper),
                'migration' => $this->makeMigration($nameLower),
                'controller' => $this->makeController($nameUpper),
                'request' => $this->makeRequest($nameUpper),
                'view' => $this->makeView($nameLower),
                'service' => $this->makeService($nameUpper),
                'repository' => $this->makeRepository($nameUpper),
                'seeder' => $this->makeSeeder($nameUpper),
                'factory' => $this->makeFactory($nameUpper),
            };
        }
    }

    /**
     * Create Model File
     */
    private function makeModel(string $name): void
    {
        $this->call('make:model', ['name' => $name]);
    }

    /**
     * Build migration file with call command.
     */
    private function makeMigration(string $name): void
    {
        $name = File::getCurrentNameWithCheckLatestLetter($name);
        $name = str_replace('/', '_', $name);
        $this->call('make:migration', ['name' => "create_{$name}_table", '--create']);
    }

    /**
     * Build controller file with call command.
     */
    private function makeController(string $name): void
    {
        $this->call('make:controller', ['name' => "{$name}Controller"]);
    }

    /**
     * Build request file with call command.
     */
    private function makeRequest(string $name): void
    {
        $this->call('make:request', ['name' => "{$name}StoreRequest"]);
        $this->call('make:request', ['name' => "{$name}UpdateRequest"]);
    }

    /**
     * Build view file with call command.
     *
     *
     * @return void
     */
    private function makeView(string $name)
    {
        $name = File::getCurrentNameWithCheckLatestLetter($name);

        $pathSource = File::getPath('resources', 'views', $name);

        $files = [];
        $files[] = $this->makeStubFile(
            $pathSource,
            'index',
            '.blade',
            'blade',
            false,
        );

        $files[] = $this->makeStubFile(
            $pathSource,
            'create',
            '.blade',
            'blade',
            false,
        );

        $files[] = $this->makeStubFile(
            $pathSource,
            'edit',
            '.blade',
            'blade',
            false,
        );

        $paths = File::getShortPathForFiles($files);

        $this->table(['Views'], array_map(fn ($path) => [$path], $paths));
    }

    /**
     * Build service file with call command.
     */
    private function makeService(string $name): void
    {
        $file = $this->makeStubFile(File::getPath('app', 'Services'), $name, 'Service', 'service');
        $this->table(['Service'], [[File::getShortPath($file)]]);
    }

    /**
     * Build repository file with call command.
     *
     *
     * @return void
     */
    private function makeRepository(string $name)
    {
        $this->makeStubFile(
            File::getPath('app', 'Repositories'),
            $name,
            config('laravel-easy.repository_namespace', 'Repository'),
            'repository',
        );
    }

    /**
     * Build seeder file with call command.
     *
     *
     * @return void
     */
    private function makeSeeder(string $name)
    {
        $this->call('make:seeder', [
            'name' => $name.'Seeder',
        ]);
    }

    /**
     * Build factory file with call command.
     *
     *
     * @return void
     */
    private function makeFactory(string $name)
    {
        $this->call('make:factory', [
            'name' => $name.'Factory',
        ]);
    }
}
