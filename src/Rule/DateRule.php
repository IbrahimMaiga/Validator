<?php
namespace Validator\Rule;

/**
 * Class DateRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class DateRule extends AbstractRule
{

    public function defineProcess($date, $format)
    {
      $formattedDate = DateTime::createFromFormat($format, $date);
      return $formattedDate && $formattedDate->format($format) === $date;
    }

    public function error()
    {
        return '${value} is not conform to date format ${actual}';
    }
}
