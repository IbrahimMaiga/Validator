<?php
namespace Validator\Exception;


use Throwable;

/**
 * Class RuleNotFoundException
 * @package Validator\Exception
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class RuleNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}