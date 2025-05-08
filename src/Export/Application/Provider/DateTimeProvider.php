<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Provider;

interface DateTimeProvider
{
    public function getCurrent(string $format): string;
}
