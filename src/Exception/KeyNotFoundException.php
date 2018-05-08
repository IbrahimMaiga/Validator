<?php

namespace Validator\Exception;

use Throwable;

/**
 * Class KeyNotFoundException
 * @package Validator\Exception
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class KeyNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}