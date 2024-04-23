<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer\DataFlattener;

class DataFlattenerTest extends TestCase
{
    private DataFlattener $flattedData;

    protected function setUp(): void
    {
        $this->flattedData = new DataFlattener();
    }

    public function testToNestedArray(): void
    {
        $inputData = [
            'article.name' => 'Test Article',
            'article.id' => 1,
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
                'parent' => 1,
            ],
        ];
        $order = ['article.id', 'article.name', 'articlehierarchy.level', 'articlehierarchy.parent'];
        $outputData = $this->flattedData->toNestedArray($inputData, $order);
        $this->assertSame($expectedOutput, $outputData);
    }
}
