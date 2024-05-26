<?php

namespace Oosaulenko\MediaBundle\Utilities;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    /**
     * @param UploadedFile $file
     * @return array|null
     */
    public function upload(UploadedFile $file): ?array;
}