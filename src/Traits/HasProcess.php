<?php

namespace Elsayed85\LaravelEasy\Traits;

use Closure;
use Illuminate\Process\ProcessResult;
use Illuminate\Support\Facades\Process;

trait HasProcess
{
    private $processResult;

    public function process(string $command, Closure $success = null, Closure $fail = null): int
    {
        $this->processResult = Process::run($command);

        if ($this->processResult->exitCode() === 1 || $this->processResult->failed()) {
            if ($fail) {
                return $fail();
            }

            return self::FAILURE;
        }

        if ($this->processResult->successful()) {
            if ($success) {
                return $success();
            }

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    public function getProcessResult(): ProcessResult
    {
        return $this->processResult;
    }
}
