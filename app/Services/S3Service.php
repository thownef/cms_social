<?php

namespace App\Services;

use App\Contracts\Services\S3ServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class S3Service implements S3ServiceInterface
{
    const SEPARATOR = DIRECTORY_SEPARATOR;

    private $driver;

    private string $path;

    public function __construct()
    {
        $this->driver = $this->getDriver();
        $this->setPath();
    }

    public function getDriver()
    {
        return Storage::disk('local');
    }

    public function setPath(string $path = '')
    {
        $this->path = empty($path) ? config('services.s3.path') : $path;
    }

    public function getAllFile(string $folder = '')
    {
        return $this->driver->allFiles($folder);
    }

    public function putFile(string $fileName, string $contents, string $folder = ''): string
    {
        $filePath = $this->makeFilePath(fileName: $fileName, folderName: $folder);

        if (config('app.env') === 'local') {
            $this->driver->put($filePath, $contents);
        }

        return $this->path.self::SEPARATOR.$filePath;
    }

    public function deleteFile(string $path = '')
    {
        $path = Str::replace($this->path.self::SEPARATOR, '', $path);
        if ($this->driver->exists($path)) {
            return $this->driver->delete($path);
        }

        return false;
    }

    private function makeFilePath(string $fileName, string $folderName = '')
    {
        $rootFolder = config('services.s3.folder_path').self::SEPARATOR;

        if (empty($folderName)) {
            return $rootFolder.$fileName;
        }

        return $rootFolder.$folderName.self::SEPARATOR.$fileName;
    }
}
