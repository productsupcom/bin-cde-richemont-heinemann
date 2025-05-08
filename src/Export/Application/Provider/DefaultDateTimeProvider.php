<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Provider;

use DateTimeImmutable;

class DefaultDateTimeProvider implements DateTimeProvider
{
    public function getCurrent(string $format): string
    {
        return (new DateTimeImmutable())->format($format);
    }
}
