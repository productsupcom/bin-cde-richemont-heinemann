<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Service\Upload\Sftp;

use Exception;
use League\Flysystem\Config;
use League\Flysystem\ConnectionRuntimeException;
use League\Flysystem\Sftp\SftpAdapter;
use Productsup\BinCdeHeinemann\Events\Debug\UnableToUploadFile;
use Productsup\BinCdeHeinemann\Exceptions\Client\ConnectionException;
use Productsup\BinCdeHeinemann\Exceptions\Engineering\UploadException;
use Productsup\BinCdeHeinemann\Service\Upload\Ftp\Configuration;
use Productsup\BinCdeHeinemann\Service\Upload\MultipleUpload\TransportInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SftpUploader implements TransportInterface
{
    public function __construct(
        private SftpAdapter $sftpAdapter,
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

    private function uploadFile(array $createdFiles): void
    {
        foreach ($createdFiles as $file) {
            $localFile = $file;
            $remoteFile = basename($file);

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
}
