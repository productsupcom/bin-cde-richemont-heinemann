<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\ValueObject;

final class Configuration
{
    private const DEFAULT_PORT = 21;
    private string $host;
    private int $port;

    public function __construct(
        private string $ftpHost,
        private bool $isPassiveMode,
        private string $username,
        private string $password,
        private string $file,
        private string $directory
    ) {
        $this->initHostAndPort();
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function isPassiveMode(): bool
    {
        return $this->isPassiveMode;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    private function initHostAndPort(): void
    {
        $host = preg_replace('#^s?ftps?://#', '', $this->ftpHost);
        $host = rtrim($host, ' /:');
        $position = strpos($host, ':');

        if (false === $position) {
            $this->host = $host;
            $this->port = self::DEFAULT_PORT;

            return;
        }

        $this->host = substr($host, 0, $position);
        $this->port = (int)(substr($host, $position + 1) ?: self::DEFAULT_PORT);
    }
}
