<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Transporter;

interface Transporter
{
    public function transport(): void;
}
