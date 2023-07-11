<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Sftp\SftpAdapter;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\Configuration;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\FtpUploader;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Sftp\SftpUploader;
use Symfony\Component\Messenger\MessageBusInterface;

final class AdapterFactory
{
    public function __construct(
        private Ftp $ftp,
        private SftpAdapter $sftp,
        private Configuration $configuration,
        private MessageBusInterface $messageBus
    ) {
    }

    public function make(): FtpUploader|SftpUploader
    {
        $protocol = $this->configuration->getProtocol();

        return match ($protocol) {
            'sftp' => new SftpUploader($this->sftp, $this->configuration, $this->messageBus),
            default => new FtpUploader($this->ftp, $this->configuration, $this->messageBus),
        };
    }
}
