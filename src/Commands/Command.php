<?php

namespace Elsayed85\LaravelEasy\Commands;

use Elsayed85\LaravelEasy\Traits\HasComposer;
use Elsayed85\LaravelEasy\Traits\HasProcess;
use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand
{
    use HasComposer;
    use HasProcess;
}
