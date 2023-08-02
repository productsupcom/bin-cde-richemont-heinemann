<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Helper;

trait FixtureHelper
{
    public function getFixture(string $basePath, string $fileName): string
    {
        $path = $basePath.$fileName;

        return !file_exists($path)
            ? ''
            : file_get_contents($path);
    }
}
