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
        return isset($value) && !empty($value);
    }

    public function error()
    {
        return 'the value of field $(field) is required';
    }
}