<?php

namespace Elsayed85\LaravelEasy\Services;

class VendorPublish
{
    private $command = 'php artisan vendor:publish';

    public function getFullCommand()
    {
        return $this->command;
    }

    public function tag($tag)
    {
        $this->command .= " --tag=$tag";

        return $this;
    }

    public function provider($provider)
    {
        $this->command .= " --provider=$provider";

        return $this;
    }

    public function force()
    {
        $this->command .= ' --force';

        return $this;
    }

    public function all()
    {
        $this->command .= ' --all';

        return $this;
    }
}
