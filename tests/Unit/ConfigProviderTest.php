<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Provider\ConfigProvider;

class ConfigProviderTest extends TestCase
{
    private const REMOTE_FILE = 'remote_file_value';
    private const FEED_NAME = 'feed_name_value';
    private const FTP_HOST = 'ftp_host_value';
    private const FTP_DIRECTORY = 'ftp_directory_value';

    private ConfigProvider $configProvider;

    protected function setUp(): void
    {
        $this->configProvider = new ConfigProvider(self::REMOTE_FILE, self::FEED_NAME, self::FTP_HOST, self::FTP_DIRECTORY);
    }

    public function testGetRemoteFile(): void
    {
        self::assertSame(self::REMOTE_FILE, $this->configProvider->getRemoteFile());
    }

    public function testGetDirectory(): void
    {
        self::assertSame(self::FTP_DIRECTORY, $this->configProvider->getDirectory());
    }

    public function testGetFeedName(): void
    {
        self::assertSame(self::FEED_NAME, $this->configProvider->getFeedName());
    }

    public function testGetHost(): void
    {
        self::assertSame(self::FTP_HOST, $this->configProvider->getHost());
    }
}
