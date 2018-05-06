<?php
namespace Validator\Rule;

/**
 * Class RequiredRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class RequiredRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return !empty($value);
    }

    public function error()
    {
        return 'the field $(field) value $(value) not equals to $(actual)';
    }
}