<?php
namespace Validator\Utils;

/**
 * Class Helpers
 * @package Validator\Utils
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class Helpers
{
    /**
     * Helpers constructor.
     */
    private function __construct()
    {
        // prevent initialisation
    }

    public static function getName($obj, string $suffix = '')
    {
        $className = get_class($obj);
        $tempArray = explode('\\', $className);
        $className = $tempArray[count($tempArray) - 1];
        $first = strtolower(substr($className, 0, 1));
        $length = strpos(strtolower($className), $suffix) === false ? null
        :  strlen($className) - (strlen($suffix) + 1);
        $end = substr($className, 1, $length);
        return $first . $end;
    }

}