<?php
namespace Validator\Rule;

/**
 * Class EmailRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class EmailRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) === $value;
    }

    public function error()
    {
        return '${value} is not a valid mail address';
    }
}