<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\ValueObject\Configuration;

final class ConfigurationTest extends TestCase
{
    private $ftpHost = 'ftp://127.0.0.1';

    public function testCanBeCreatedFromValidRecord(): void
    {
        $config = new Configuration(
            $this->ftpHost,
            true,
            'username',
            'password',
            '/path/to/file.txt',
            '/path/to/'
        );
        $this->assertEquals('127.0.0.1', $config->getHost());
        $this->assertEquals(21, $config->getPort());
        $this->assertEquals(true, $config->isPassiveMode());
        $this->assertEquals('username', $config->getUsername());
        $this->assertEquals('password', $config->getPassword());
        $this->assertEquals('/path/to/file.txt', $config->getFile());
        $this->assertEquals('/path/to/', $config->getDirectory());
    }
}
