<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\Transfomer\FlattedData;

class FlattedDataTest extends TestCase
{
    private FlattedData $flattedData;

    protected function setUp(): void
    {
        $this->flattedData = new FlattedData();
    }

    public function testToNestedArray(): void
    {
        $inputData = [
            'article.id' => 1,
            'article.name' => 'Test Article',
            'articlehierarchy.level' => 2,
            'articlehierarchy.parent' => 1,
        ];

        $expectedOutput = [
            [
                'id' => 1,
                'name' => 'Test Article',
            ],
            [
                'level' => 2,
                'parent' => 1
            ]
        ];

        $outputData = $this->flattedData->toNestedArray($inputData);
        $this->assertSame($expectedOutput, $outputData);
    }
}