<?php

namespace App\Contracts\Services;

interface S3ServiceInterface
{
    public function setPath(string $path = '');

    public function getAllFile(string $folder = '');

    public function putFile(string $fileName, string $contents, string $folder = ''): string;

    public function deleteFile(string $path = '');
}
