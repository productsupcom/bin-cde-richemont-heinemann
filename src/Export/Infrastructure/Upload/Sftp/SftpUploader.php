<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Sftp;

use Exception;
use League\Flysystem\Config;
use League\Flysystem\ConnectionRuntimeException;
use League\Flysystem\Sftp\SftpAdapter;
use Productsup\BinCdeHeinemann\Export\Domain\Upload\TransportInterface;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Event\UnableToUploadFile;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception\ConnectionException;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception\UploadException;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\Configuration;
use Symfony\Component\Messenger\MessageBusInterface;

class SftpUploader
{
    public function __construct(
        private SftpAdapter $sftpAdapter,
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
            $this->sftpAdapter->setHost($this->configuration->getHost());
            $this->sftpAdapter->setPort($this->configuration->getPort());
            $this->sftpAdapter->setUsername($this->configuration->getUsername());
            $this->sftpAdapter->setPassword($this->configuration->getPassword());
            $this->sftpAdapter->setRoot($this->configuration->getDirectory());

            $this->sftpAdapter->connect();
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
            $sftpUpload = $this->sftpAdapter->writeStream(
                path: $remoteFile,
                resource: $filePointer,
                config: new Config()
            );

            if (!$sftpUpload) {
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
