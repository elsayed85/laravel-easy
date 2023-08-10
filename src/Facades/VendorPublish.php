<?php

namespace Elsayed85\LaravelEasy\Facades;

use Illuminate\Support\Facades\Facade;

class VendorPublish extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Elsayed85\LaravelEasy\Services\VendorPublish::class;
    }
}
