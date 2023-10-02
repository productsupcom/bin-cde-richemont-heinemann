<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application;

interface Transport
{
    public function upload(): void;
}
