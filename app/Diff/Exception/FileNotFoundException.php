<?php

declare(strict_types=1);

namespace App\Libraries\Diff\Exception;

final class FileNotFoundException extends \Exception
{
    public function __construct(string $filepath = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct("File not found: {$filepath}", $code, $previous);
    }
}
