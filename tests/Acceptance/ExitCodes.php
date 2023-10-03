<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Acceptance;

interface ExitCodes
{
    public const COMMAND_SUCCESS = 0;
    public const COMMAND_FAILURE = 1;
    public const ERROR_CODE_SUPPORT_LEVEL = 224;
    public const ERROR_CODE_ENGINEERING_LEVEL = 192;
    public const ERROR_CODE_CLIENT_LEVEL = 240;
    public const ERROR_CODE_FEEDBACK_FILE = 10;
}
