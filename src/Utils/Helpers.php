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

    /**
     * Return the part of class name
     * @param $obj
     * @param string $suffix
     * @return string|false part of obj class name if class name if not anonymous class other
     * otherwise false
     * throw RuntimeException
     */
    public static function getName($obj, string $suffix = '')
    {
        $className = get_class($obj);
        if (false !== self::isAnonymousClass($className)) {
            $tempArray = explode('\\', $className);
            $className = $tempArray[count($tempArray) - 1];
            $first = strtolower(substr($className, 0, 1));
            $length = strpos(strtolower($className), $suffix) === false ? null
                :  strlen($className) - (strlen($suffix) + 1);
            $end = substr($className, 1, $length);
            return $first . $end;
        }

        return false;
    }

    /**
     * Check if class name correspond to anonymous class name
     * @param string $className the class name to check
     * @return bool return true if class is anonymous class otherwise false
     */
    public static function isAnonymousClass(string $className)
    {
        return strpos($className, 'class@anonymous') >= 0;
    }

}