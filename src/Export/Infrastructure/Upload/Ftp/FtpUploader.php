<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp;

use Exception;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Config;
use League\Flysystem\ConnectionRuntimeException;
use Productsup\BinCdeNegativeExport\Service\Upload\Exception\ConnectionException;
use Productsup\BinCdeNegativeExport\Service\Upload\Exception\UploadException;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\RemotePath\RemotePathBuilderInterface;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\ValueObject\Configuration;

final class FtpUploader implements FtpUploaderInterface
{
    public function __construct(
        private Ftp $ftp,
        private Configuration $configuration,
        private RemotePathBuilderInterface $pathBuilder
    ) {
    }

    public function upload(string $filename): void
    {
        $this
            ->connect()
            ->uploadFile($filename);
        @unlink($filename);
    }

    private function connect(): self
    {
        try {
            $this->ftp->setHost($this->configuration->getHost());
            $this->ftp->setPort($this->configuration->getPort());
            $this->ftp->setPassive($this->configuration->isPassiveMode());
            $this->ftp->setUsername($this->configuration->getUsername());
            $this->ftp->setPassword($this->configuration->getPassword());

            $this->ftp->connect();
        } catch (ConnectionRuntimeException $exception) {
            throw ConnectionException::dueToPrevious($exception);
        }

        return $this;
    }

    private function uploadFile(string $localFile): void
    {
        $remoteFile = $this->pathBuilder->build($this->configuration->getDirectory(), $this->configuration->getFile());
        $filePointer = fopen($localFile, 'rb');

        try {
            $isWriteSuccessful = $this->ftp->writeStream(
                path: $remoteFile,
                resource: $filePointer,
                config: new Config()
            );

            if (!$isWriteSuccessful) {
                throw UploadException::failedUpload(
                    $remoteFile,
                    $this->configuration->getHost(),
                    $this->configuration->getPort()
                );
            }

            return;
        } catch (Exception $exception) {
            throw UploadException::failedUpload(
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
