<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Exceptions;

use Exception;
use Throwable;

class TypeClassDoesNotExistException extends Exception
{
    /**
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = 'Could not find class that needs to be constructed in given type.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
