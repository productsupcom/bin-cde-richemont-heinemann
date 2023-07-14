#!/usr/bin/env php
<?php

date_default_timezone_set('Europe/Berlin');
ini_set('memory_limit', '-1');

use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\ExportCommand;
use Productsup\CDE\Connector\Infrastructure\Console;

require_once __DIR__ . '/vendor/autoload_runtime.php';

return static fn (array $context) => (new Console($context))
    ->add(ExportCommand::class)
        ->getApplication()
;
