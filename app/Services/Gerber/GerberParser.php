<?php

namespace App\Services\Gerber;

use Illuminate\Support\Facades\File;

class GerberParser
{
    public function parse(string $directory): array
    {
        $file = $this->findEdgeCuts($directory);

        $x = $y = null;

        $minX = $minY = PHP_FLOAT_MAX;
        $maxX = $maxY = -PHP_FLOAT_MAX;

        foreach (file($file->getPathname()) as $line) {

            if (preg_match('/X(-?\d+)/', $line, $match)) {
                $x = $match[1] / 1000000;
            }

            if (preg_match('/Y(-?\d+)/', $line, $match)) {
                $y = $match[1] / 1000000;
            }

            if ($x === null || $y === null) {
                continue;
            }

            if (!str_contains($line, 'D01')) {
                continue;
            }

            $minX = min($minX, $x);
            $maxX = max($maxX, $x);

            $minY = min($minY, $y);
            $maxY = max($maxY, $y);
        }

        if ($minX === PHP_FLOAT_MAX) {
            throw new \Exception('Unable to determine PCB dimensions.');
        }

        return [
            'width' => round($maxX - $minX, 2),
            'height' => round($maxY - $minY, 2),
        ];
    }

    private function findEdgeCuts(string $directory)
    {
        foreach (File::allFiles($directory) as $file) {

            if (
                str_contains($file->getFilename(), 'Edge_Cuts') ||
                str_contains(File::get($file), 'FileFunction,Profile')
            ) {
                return $file;
            }
        }

        throw new \Exception('PCB outline not found. Please make sure your Gerber ZIP contains the Edge_Cuts layer.');
    }
}