<?php
namespace Validator\Rule;


class StringRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return is_string($value);
    }

    public function error()
    {
        return '${value} must be a string';
    }
}