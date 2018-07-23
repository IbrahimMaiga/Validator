<?php
namespace Validator\Rule;

use Validator\Storage\MessageStorage;
use Validator\Utils\Helpers;

/**
 * Class AbstractRule
 * @package Validator\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
abstract class AbstractRule implements Rule
{
    /**
     * @var MessageStorage
     */
    private $storage;

    /**
     * @var array
     */
    private $defaultErrorMessages;

    /**
     * AbstractRule constructor.
     * @param MessageStorage $storage
     * @param array $defaultErrorMessages
     */
    public function __construct(MessageStorage &$storage, array $defaultErrorMessages = [])
    {
        $this->storage = $storage;
        $this->defaultErrorMessages = $defaultErrorMessages;
    }

    /**
     * @return MessageStorage
     */
    public function getStorage()
    {
        return $this->storage;
    }

    public function evaluate(string $fieldName, $value, $actual)
    {
        if (false === $this->defineProcess($value, $this->getReal($actual))) {
            $this->errorProcess($fieldName);
            return false;
        }
        return true;
    }

    public function name()
    {
        return Helpers::getName($this, 'rule');
    }

    private function errorProcess($fieldName)
    {
        $name = $this->name();
        $this->storage->checkAndSet(
            $fieldName, $name,
            empty($this->defaultErrorMessages)
            ? $this->error()
            : $this->defaultErrorMessages[$this->name()]
        );
    }

    protected function length($value)
    {
        if (is_string($value)) {
            return strlen($value);
        } else if (is_int($value)) {
            return (int)$value;
        } else if (is_array($value)) {
            return count($value);
        } else {
            return $value;
        }
    }

    private function getReal($value)
    {
        if (is_int($value)) {
            return (int)$value;
        }
        return $value;
    }
    
    public abstract function defineProcess(array$value, $actual);
    public abstract function error();
}
