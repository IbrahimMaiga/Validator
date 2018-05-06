<?php
namespace Validator\Rule;

/**
 * Class EqualsRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class EqualsRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return $value === $actual;
    }

    public function error()
    {
        return 'the field $(field) value $(value) not equals to $(actual)';
    }
}