<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Transporter;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToWriteFile;
use Productsup\BinCdeHeinemann\Export\Application\Provider\FileNameProvider;
use Productsup\BinCdeHeinemann\Export\Application\Transporter\Transporter;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Transporter\Exception\UploadFailed;

final class S3Transporter implements Transporter
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private FileNameProvider $fileNameProvider,
        private readonly string $tempFilename
    ) {
    }

    public function transport(): void
    {
        $key = ltrim($this->fileNameProvider->provide(), '/');

        try {
            $this->filesystem->writeStream($key, fopen($this->tempFilename, 'rb'));
        } catch (FilesystemException|UnableToWriteFile $exception) {
            throw UploadFailed::dueToPrevious($exception);
        }
    }
}
