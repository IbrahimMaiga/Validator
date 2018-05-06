<?php
namespace Validator\Rule;

/**
 * Class MinStrictRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MinStrictRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return $this->length($value) > $actual;
    }

    public function error()
    {
        return 'the field $(field) value $(value) not equals to $(actual)';
    }
}