<?php
namespace Validator\Rule;

/**
 * Class MaxRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MaxRule extends AbstractRule
{
    public function defineProcess($value, $actual)
    {
        return $this->length($value) <= $actual;
    }

    public function error()
    {
        return 'the field $(field) with value $(value) must be less than or equal $(actual)';
    }
}