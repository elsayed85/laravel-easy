<?php

namespace Elsayed85\LaravelEasy\Facades;

use Illuminate\Support\Facades\Facade;

class File extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elsayed85\LaravelEasy\Services\File::class;
    }
}
