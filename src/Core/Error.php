<?php
namespace Validator\Core;

use Validator\Storage\GroupInterface;
use Validator\Storage\MessageStorage;

/**
 * Interface Error
 * @package Validator\Core
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
interface Error
{
    /**
     * Returns array of all errors occurred during validation
     * @return MessageStorage errors if validation failed
     */
    public function getErrors();

    /**
     * Returns Group of all errors corresponding to key $fieldName
     * @param string $fieldName error group key
     * @return GroupInterface errors if validation failed
     */
    public function getTargetedErrors(string $fieldName);
}