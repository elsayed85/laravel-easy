<?php

namespace Elsayed85\LaravelEasy\Services;

class File
{
    /**
     * Get current name with check latest letter ex (category => categories - product => products).
     *
     *
     * @return string
     */
    public function getCurrentNameWithCheckLatestLetter(string $name, bool $needToLower = true)
    {
        if (str_ends_with($name, 'y')) {
            $name = substr_replace($name, '', -1);
            $name .= 'ies';
        } else {
            $name .= 's';
        }

        return $needToLower
            ? strtolower($name)
            : $name;
    }

    /**
     * Change backslash to slash.
     *
     *
     * @return string
     */
    public function changeBackSlashToSlash(string $str)
    {
        return str_replace('\\', '/', $str);
    }

    public function formatPathToNamespace($path)
    {
        return ucfirst(str_replace('/', '\\', $path));
    }

    public function getPath(...$paths)
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    public function getShortPath($path)
    {
        return str_replace(base_path().'/', '', $path);
    }

    public function getShortPathForFiles($files)
    {
        return array_map(function ($file) {
            return $this->getShortPath($file);
        }, $files);
    }
}
