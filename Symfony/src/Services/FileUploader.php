<?php

namespace App\Services;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        protected FilesystemOperator $uploadsArticlesFilesystem,
        protected SluggerInterface $slugger
    ) {
    }

    public function uploadFile(
        File $uploadedFile,
        ?string $oldFileName = null
    ): string {
        $fileName = $this->slugger
            ->slug(pathinfo(
                $uploadedFile instanceof UploadedFile ? $uploadedFile->getClientOriginalName() : $uploadedFile->getFilename(),
                PATHINFO_FILENAME
            ))
            ->append('-' . uniqid())
            ->append('.' . $uploadedFile->guessExtension())
            ->toString()
        ;

        $stream = fopen($uploadedFile->getPathname(), 'r');

        $this->uploadsArticlesFilesystem->writeStream($fileName, $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        if ($oldFileName && $this->uploadsArticlesFilesystem->has($oldFileName)) {
            $this->uploadsArticlesFilesystem->delete($oldFileName);
        }

        return $fileName;
    }
}