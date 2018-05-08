<?php

namespace Validator\Core;

use Noodlehaus\Config;
use Validator\Exception\RuleExistException;
use Validator\Exception\RuleNotFoundException;
use Validator\Exception\ValidationException;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\GroupInterface;
use Validator\Storage\MessageStorage;
use Validator\Utils\Helpers;

/**
 * Class AbstractValidator
 * @package Validator\Core
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
abstract class AbstractValidator implements Validator, Error
{
    private const REGEX = '/(\w[A-Za-z0-9_$]+)\(([A-Za-z0-9]+)\)/';
    private const REPLACEMENT_REGEX = '/\$\((\w+)\)/';
    private const COLON = ':';
    private const PIPE = '|';
    private const COMMA = ',';
    private const FIELD = 'field';
    private const VALUE = 'value';
    private const ACTUAL = 'actual';

    /**
     * @var array $defaultRulesClasses all default rules
     */
    private static $defaultRulesClasses = [
        'max' => 'Validator\Rule\MaxRule',
        'maxStrict' => 'Validator\Rule\MaxStrictRule',
        'min' => 'Validator\Rule\MinRule',
        'minStrict' => 'Validator\Rule\MinStrictRule',
        'equals' => 'Validator\Rule\EqualsRule',
        'match' => 'Validator\Rule\MatchRule',
        'required' => 'Validator\Rule\RequiredRule',
    ];

    /**
     * @var array $rulesInstances
     * store instances of rules to avoid creating them each time
     */
    private static $rulesInstances = [];

    /**
     * @var array $optionalRules
     * optional rules
     */
    private static $optionalRules = [];

    /**
     * @var MessageStorage $storage
     * store all errors occurred
     */
    private $storage;

    /**
     * @var array $definedRules
     */
    private $definedRules;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $bindData = [];

    /**
     * AbstractValidator constructor.
     * @param MessageStorage|null $storage
     * @param Config $config
     */
    public function __construct(MessageStorage $storage = null, Config $config = null)
    {
        $this->storage = $storage ?: new DefaultMessageStorage();
        $this->config = $config;
    }

    /**
     * Returns true if validation passes false otherwise
     * @param array $data data to check
     * @param array $optionals optional rules
     * @return true if validation passes false otherwise
     */
    public function validate(array $data, array $optionals = [])
    {
        $rules = [];
        if ($this->config !== null) {
            $this->checkInconsistency(array_keys(!empty($this->key())
                ? $this->config->get($this->key())
                : $this->config->all()), array_keys($data));

            $name = !empty($this->key()) ? $this->key() : Helpers::getName($this, $this->getSuffix());
            foreach ($data as $key => $value) {
                $temp = $key;
                if ($this->config->has($name)) {
                    $key = "$name.$key";
                }
                $rules[$temp] = $this->config->get($key);
            }
        } else {
            if (!empty($this->definedRules)) {
                $this->checkInconsistency(array_keys($this->definedRules), array_keys($data));
                $rules = $this->definedRules;
            } else {
                return false;
            }
        }

        return $this->validateRules($rules, $data, $optionals);
    }

    /**
     * Returns true if everything went well false otherwise
     * @param array $rules to evaluate
     * @param array $data to check
     * @param array $optionals optional rules
     * @return true if everything went well false otherwise
     */
    private function validateRules(array $rules, $data, $optionals)
    {
        $validation = true;
        $params = [];
        $rulesClasses = array_merge(self::$defaultRulesClasses, $this->additionalRules());
        foreach ($rules as $key => $value) {
            $realRules = $value;
            if (strpos($value, self::PIPE)) {
                $explodedValue = explode(self::PIPE, $value);
                self::$optionalRules[$key] = $explodedValue;
                $realRules = array_shift($explodedValue);
            }

            if (strpos($realRules, self::COLON)) {
                $realRules = explode(self::COLON, $realRules);
            }

            if (!is_array($realRules)) {
                $realRules = [$realRules];
            }

            // add optionals rule to rules
            foreach ($optionals as $optional) {
                if (in_array($optional, self::$optionalRules)) {
                    $realRules[] = $optional;
                }
            }

            $ruleInstanceKeys = array_keys(self::$rulesInstances);
            foreach ($realRules as $realRule) {
                $parseResult = $this->parse($realRule);
                $userMethod = false;
                if (!array_key_exists($realRule, $ruleInstanceKeys)) {
                    $realRule = $parseResult === false ? $realRule : $parseResult[0];
                    if (strpos($realRule, self::COMMA)) {
                        throw new \RuntimeException('Incorrect value in parameters');
                    }

                    if (in_array($realRule, array_keys($rulesClasses))) {
                        $class = $rulesClasses[$realRule];
                        self::$rulesInstances[$realRule] = new $class($this->storage);
                    } elseif (in_array($realRule, array_diff(get_class_methods($this),
                        get_class_methods(get_parent_class($this))))) {
                        if (!in_array($realRule, array_keys($rulesClasses))) {
                            $userMethod = true;
                        } else {
                            throw new RuleExistException(sprintf('the rule %s already exists
                             in the list of rules, we can only replace a rule by overloading the method 
                             additionalRules()', $realRule));
                        }
                    } else {
                        throw new RuleNotFoundException(sprintf('%s not found in rules', $realRule));
                    }
                }
                $parseKey = $parseResult === false ? '' : $parseResult[1];
                if ($parseResult !== false) {
                    if (strpos($parseKey, self::COLON)) {
                        $parseKey = substr($parseKey, 1);
                    }

                    if (array_key_exists($parseKey, $rules) && array_key_exists($parseKey, $data)) {
                        $parseKey = $data[$parseKey];
                    } else {
                        throw new \RuntimeException(sprintf('key %s not found', $parseKey));
                    }
                }
                $params[$realRule] = [self::FIELD => $key, self::VALUE => $data[$key], self::ACTUAL => $parseKey];
                $evaluation = $userMethod === true
                    ? call_user_func_array([$this, $realRule], [$data[$key], $parseKey])
                    : self::$rulesInstances[$realRule]->evaluate($key, $data[$key], $parseKey);
                $validation = $validation && $evaluation;
            }
        }
        if (!$validation) {
            $this->doBinding($this->bindData);
            $this->formatErrors($this->storage, $params);
        }
        return $validation;
    }

    /**
     * Binds a custom message to the error
     * @param string $fieldName the group key
     * @param string $rule rule who caused error
     * @param string $message error message
     */
    public function bindMessage($fieldName, $rule, $message)
    {
        $this->bindData[] = [$fieldName, $rule, $message];
    }

    /**
     * Sets defined rules
     * this approach works only if a configuration file is not given,
     * otherwise it will be ignored
     * @param array $rules
     */
    public function defineRules(array $rules)
    {
        $this->definedRules = $rules;
    }

    /**
     * Way to extend rules
     * @return array the rules to add to the default rules
     */
    public function additionalRules()
    {
        return [];
    }

    /**
     * Returns class name suffix
     * @return string class name suffix
     */
    public function getSuffix() {
        return 'validator';
    }

    /**
     * Returns the json configuration key that identity rules group, only for json configuration
     * with some classes data configuration
     * @return string the json configuration key that identity rules group
     */
    public function key() {
        return '';
    }

    /**
     * @param array $bindData
     */
    private function doBinding(array $bindData)
    {
        foreach ($bindData as $data) {
            $this->storage->checkAndSet($data[0], $data[1], $data[2]);
        }
        $this->bindData = [];
    }

    /**
     * Format errors by replacing parameters in message text
     * @param MessageStorage $storage
     * @param array $params the parameters to replace in the storage
     */
    private function formatErrors(MessageStorage &$storage, $params)
    {
        $errors = $storage->toArray();
        foreach ($errors as $groupName => $groupData) {
            foreach ($groupData as $rule => $message) {
                $formattedMessage = preg_replace_callback(self::REPLACEMENT_REGEX,
                    function ($matches) use ($params, $rule) {
                        return $params[$rule][$matches[1]];
                }, $message);
                $storage->getGroup($groupName)->set($rule, $formattedMessage);
            }
        }
    }

    /**
     * @param string $value subject to match
     * @return bool return params if pattern match false otherwise
     */
    private function parse(string $value)
    {
        if (preg_match(self::REGEX, $value, $params)) {
            array_shift($params);
            return $params;
        }
        return false;
    }

    /**
     * Checks if the data is consistent, if yes a Validator exception is throw
     * @param array $ruleKeys rule keys
     * @param array $dataKeys user data keys
     */
    private function checkInconsistency($ruleKeys, $dataKeys)
    {
        if (count($ruleKeys) !== count($dataKeys)) {
            $this->throwInconsistencyException();
        }
        foreach ($ruleKeys as $ruleKey) {
            if (!in_array($ruleKey, $dataKeys)) {
                $this->throwInconsistencyException();
            }
        }
    }

    /**
     * trow ValidationException if the data is inconsistent
     */
    private function throwInconsistencyException()
    {
        throw new ValidationException('Inconsistent data structure');
    }

    /**
     * Returns array of all errors occurred during validation
     * @return MessageStorage errors if validation failed
     */
    public function getErrors()
    {
        return $this->storage;
    }

    /**
     * Returns Group of all errors corresponding to key $fieldName
     * @param string $fieldName error group key
     * @return GroupInterface  errors if validation failed
     */
    public function getTargetedErrors(string $fieldName)
    {
        return $this->storage->getGroup($fieldName);
    }
}