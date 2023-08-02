<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Provider;

final class ConfigProvider
{
    public function __construct(
        private string $remoteFile,
        private string $feedName,
        private string $ftpHost,
        private string $ftpDirectory
    ) {
    }

    public function getRemoteFile(): string
    {
        return $this->remoteFile;
    }

    public function getDirectory(): string
    {
        return $this->ftpDirectory;
    }

    public function getFeedName(): string
    {
        return $this->feedName;
    }

    public function getHost(): string
    {
        return $this->ftpHost;
    }
}
