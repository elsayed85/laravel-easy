<?php

namespace Elsayed85\LaravelEasy\Traits;

trait HasComposer
{
    public function installWithComposer(string $repository)
    {
        return 'composer require '.$repository;
    }

    public function updateWithComposer(string $repository)
    {
        return 'composer update '.$repository;
    }
}
