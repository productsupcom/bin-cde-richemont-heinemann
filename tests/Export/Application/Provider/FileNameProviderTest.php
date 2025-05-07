<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Export\Application\Provider;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\Provider\FileNameProvider;
use Productsup\BinCdeHeinemann\Tests\Mocks\DateProviderForTests;

class FileNameProviderTest extends TestCase
{
    public function testFileNameGeneration(): void
    {
        $fileNameProvider = new FileNameProvider(
            'VAL/Export/CIN',
            new DateProviderForTests()
        );

        $this->assertEquals('VAL/Export/CIN_20250311.xml', $fileNameProvider->provide());
    }
}
