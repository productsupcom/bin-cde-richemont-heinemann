<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp;

use Exception;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Config;
use League\Flysystem\ConnectionRuntimeException;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter\Uploader;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Event\UnableToUploadFile;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception\ConnectionException;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception\UploadException;
use Symfony\Component\Messenger\MessageBusInterface;

class FtpUploader implements Uploader
{
    public function __construct(
        private Ftp $ftp,
        private Configuration $configuration,
        private MessageBusInterface $messageBus,
        private string $filename
    ) {
    }

    public function upload(): void
    {
        $this
            ->connect()
            ->uploadFile($this->filename);
    }

    private function connect(): self
    {
        try {
            $this->ftp->setHost($this->configuration->getHost());
            $this->ftp->setPort($this->configuration->getPort());
            $this->ftp->setUsername($this->configuration->getUsername());
            $this->ftp->setPassword($this->configuration->getPassword());
            $this->ftp->setRoot($this->configuration->getDirectory());

            $this->ftp->connect();
        } catch (ConnectionRuntimeException $exception) {
            throw ConnectionException::dueToPrevious($exception);
        }

        return $this;
    }

    private function uploadFile(string $localFile): void
    {
        $remoteFile = basename($localFile);
        $filePointer = fopen($localFile, 'rb');

        try {
            $ftpUpload = $this->ftp->writeStream(
                path: $remoteFile,
                resource: $filePointer,
                config: new Config()
            );

            if (!$ftpUpload) {
                $this->messageBus->dispatch(UnableToUploadFile::logReason($remoteFile));

                throw UploadException::fromFailedUpload(
                    $remoteFile,
                    $this->configuration->getHost(),
                    $this->configuration->getPort()
                );
            }
        } catch (Exception $exception) {
            $this->messageBus->dispatch(UnableToUploadFile::logReason($remoteFile, $exception->getMessage()));

            throw UploadException::fromFailedUpload(
                $remoteFile,
                $this->configuration->getHost(),
                $this->configuration->getPort(),
                $exception
            );
        } finally {
            fclose($filePointer);
        }
    }
}
