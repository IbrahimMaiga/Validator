<?php
namespace Validator\Rule;

/**
 * Interface Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
interface Rule
{
    public function evaluate(string $fieldName, $value, $actual);
}