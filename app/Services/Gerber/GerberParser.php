<?php

namespace App\Services\Gerber;

use Exception;
use Illuminate\Support\Facades\File;

class GerberParser
{
    public function parse(string $directory): array
    {
        // Prefer .gbrjob if available
        if ($jobFile = $this->findGerberJob($directory)) {
            $data = json_decode(File::get($jobFile->getPathname()), true);

            if (
                isset($data['GeneralSpecs']['Size']['X']) &&
                isset($data['GeneralSpecs']['Size']['Y'])
            ) {
                return [
                    'width'  => round((float) $data['GeneralSpecs']['Size']['X'], 2),
                    'height' => round((float) $data['GeneralSpecs']['Size']['Y'], 2),
                ];
            }
        }

        return $this->parseEdgeCuts($directory);
    }

    private function parseEdgeCuts(string $directory): array
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
            throw new Exception('Unable to determine PCB dimensions.');
        }

        return [
            'width'  => round($maxX - $minX, 2),
            'height' => round($maxY - $minY, 2),
        ];
    }

    private function findGerberJob(string $directory): ?\SplFileInfo
    {
        foreach (File::allFiles($directory) as $file) {
            if (strtolower($file->getExtension()) === 'gbrjob') {
                return $file;
            }
        }

        return null;
    }

    private function findEdgeCuts(string $directory)
    {
        foreach (File::allFiles($directory) as $file) {

           $content = File::get($file->getPathname());

            if (
                str_contains($file->getFilename(), 'Edge_Cuts') ||
                str_contains($content, 'FileFunction,Profile')
            ) {
                return $file;
            }
        }

        throw new Exception('PCB outline not found. Please make sure your Gerber ZIP contains the Edge_Cuts layer.');
    }
}
