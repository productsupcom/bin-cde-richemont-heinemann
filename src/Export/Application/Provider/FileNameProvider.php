<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Provider;

class FileNameProvider
{
    public function __construct(
        private string $filename,
        private DateTimeProvider $dateTimeProvider
    ) {
    }

    public function provide(): string
    {
        $filename = trim($this->filename);

        $currentDate = $this->dateTimeProvider->getCurrent('Ymd');

        return $filename.'_'.$currentDate.'.xml';
    }
}
