<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Mocks;

use DateTimeImmutable;
use Productsup\BinCdeHeinemann\Export\Application\Provider\DateTimeProvider;

class DateProviderForTests implements DateTimeProvider
{
    public function getCurrent(string $format): string
    {
        return (new DateTimeImmutable('2025-03-11 14:00:00'))->format($format);
    }
}
