<?php
namespace Validator\Core;

/**
 * Interface Validator
 * @package Validator\Core
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
interface Validator
{
    /**
     * Returns true if validation passes false otherwise
     * @param array $data data to check
     * @param array $optionals optional rules
     * @return true if validation passes false otherwise
     */
    public function validate(array $data, array $optionals = []);
}