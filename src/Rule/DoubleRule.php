<?php
namespace Validator\Rule;

/**
 * Class DoubleRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class DoubleRule extends AbstractRule
{
    public function defineProcess($value, $actual)
    {
        return is_double($value);
    }

    public function error()
    {
        return '${value} must be a double';
    }
}