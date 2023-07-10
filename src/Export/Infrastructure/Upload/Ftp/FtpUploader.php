<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp;

use Exception;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Config;
use League\Flysystem\ConnectionRuntimeException;
use Productsup\BinCdeHeinemann\Export\Domain\Upload\TransportInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class FtpUploader implements TransportInterface
{
    public function __construct(
        private Ftp $ftp,
        private Configuration $configuration,
        private MessageBusInterface $messageBus
    ) {
    }

    public function upload(array $createdFiles): void
    {
        $this
            ->connect()
            ->uploadFile($createdFiles);
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

    private function uploadFile(array $createdFiles): void
    {
        foreach ($createdFiles as $file) {
            $localFile = $file;
            $remoteFile = basename($file);

            $filePointer = fopen($localFile, 'rb');

            try {
                $ftpUpload = $this->ftp->writeStream(
                    path: $remoteFile,
                    resource: $filePointer,
                    config: new Config()
                );

                if (!$ftpUpload) {
                    $this->messageBus->dispatch(UnableToUploadFile::logReason($remoteFile));

                    throw UploadException::failedUpload(
                        $remoteFile,
                        $this->configuration->getHost(),
                        $this->configuration->getPort()
                    );
                }
            } catch (Exception $exception) {
                $this->messageBus->dispatch(UnableToUploadFile::logReason($remoteFile, $exception->getMessage()));

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
}
