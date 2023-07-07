<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Service\Upload\Ftp;

class Configuration
{
    private ?string $protocol = null;
    private ?string $host = null;
    private const HOST = 'host';
    private const PROTOCOL = 'scheme';

    public function __construct(
        private string $ftpHost,
        private int $port,
        private string $directory,
        private string $username,
        private string $password,
        private string $remoteFile,
    ) {
        $this->initProtocolAndHost();
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRemoteFile(): string
    {
        return $this->remoteFile;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    private function initProtocolAndHost(): void
    {
        $this->protocol = $this->parseFtpOptions($this->ftpHost, self::PROTOCOL);
        $this->host = $this->parseFtpOptions($this->ftpHost, self::HOST);
        $this->host = rtrim($this->host, ' /:');
    }

    private function parseFtpOptions($option, string $key): mixed
    {
        return parse_url($option)[$key] ?? $option;
    }
}
