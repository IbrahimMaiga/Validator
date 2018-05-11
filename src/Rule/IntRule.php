<?php
namespace Validator\Rule;

/**
 * Class IntRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class IntRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return is_int($value);
    }

    public function error()
    {
        return '${value} must be an integer';
    }
}