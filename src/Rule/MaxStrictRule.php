<?php
namespace Validator\Rule;

/**
 * Class MaxStrictRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MaxStrictRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return $this->length($value) < $actual;
    }

    public function error()
    {
        return 'the field $(field) value $(value) not equals to $(actual)';
    }
}