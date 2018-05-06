<?php
namespace Validator\Rule;

/**
 * Class MatchRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MatchRule extends AbstractRule
{

    public function defineProcess($value, $actual)
    {
        return preg_match($actual, $value) != 0;
    }

    public function error()
    {
        return 'the field $(field) value $(value) not match $(actual)';
    }
}