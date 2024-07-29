<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UploadedData
{
    public $uploaded;
    public $error;
    public $originalFileName;
    public $fileName;
    public $format;
    public $path;
    public $url;

    public function __construct($uploaded, $originalFileName, $fileName, $format, $path, $url, $error = null)
    {
        $this->uploaded = $uploaded;
        $this->error = $error;
        $this->originalFileName = $originalFileName;
        $this->fileName = $fileName;
        $this->format = $format;
        $this->path = $path;
        $this->url = $url;
    }
}

class FileUtil
{
    public static function upload()
    {
        return new self();
    }

    public function image(
        UploadedFile $file,
        $path = 'images',
        $resize = 'aspect-ratio', // 'aspect-ratio' or 'cover
        $format = 'webp',
        $width = 768,
        $height = 768,
        $disk = 's3', // 'local' or 'public' or 's3'
    ): UploadedData {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $path = $this->normalizePath($path);
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFileName . '-' . $this->getUniqueString();

        match ($resize) {
            'aspect-ratio' => $image->scale(width: $width, height: $height),
            'cover' => $image->cover(width: $width, height: $height),
        };

        $binaryData = null;
        match ($format) {
            'webp' => $binaryData = $image->toWebp()->toFilePointer(),
            'png' => $binaryData = $image->toPng()->toFilePointer(),
            'jpg' => $binaryData = $image->toJpeg()->toFilePointer(),
        };

        $uploaded = true;
        $url = null;
        $error = null;

        try {
            Storage::disk($disk)->put(
                path: $path . $fileName . '.' . $format,
                contents: $binaryData,
                options: ['visibility' => 'public']
            );
            $url = url(Storage::url($path . $fileName . '.' . $format));
        } catch (\Throwable $th) {
            $uploaded = false;
            $error = $th->getMessage();
        }

        return new UploadedData(
            uploaded: $uploaded,
            error: $error,
            originalFileName: $originalFileName,
            fileName: $fileName,
            format: $format,
            path: $path,
            url: $url,
        );
    }

    public function file(
        UploadedFile $file,
        $path = 'files',
        $disk = 's3', // 'local' or 'public' or 's3'
    ): UploadedData {
        $path = $this->normalizePath($path);
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFileName . '-' . $this->getUniqueString();

        $uploaded = true;
        $url = null;
        $error = null;

        try {
            Storage::disk($disk)->putFileAs(
                path: $path,
                file: $file,
                name: $fileName,
                options: ['visibility' => 'public']
            );
            $url = url(Storage::url($path . $fileName . '.' . $file->extension()));
        } catch (\Throwable $th) {
            $uploaded = false;
            $error = $th->getMessage();
        }

        return new UploadedData(
            uploaded: $uploaded,
            error: $error,
            originalFileName: $originalFileName,
            fileName: $fileName,
            format: $file->extension(),
            path: $path,
            url: $url,
        );
    }

    private function getUniqueString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $timestamp = time(); // Get current timestamp
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= $timestamp; // Append timestamp to the random string

        return $randomString;
    }

    private function normalizePath($path)
    {
        $path = ltrim($path, '/'); // Remove leading slash

        return rtrim($path, '/') . '/';
    }
}
