<?php

namespace Validator\Storage;

/**
 * Class DefaultMessageStorage
 * @package Validator\Storage
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class DefaultMessageStorage implements MessageStorage
{
    /**
     * @var GroupInterface[]
     */
    private $groups = [];

    /**
     * DefaultMessageStorage constructor.
     * @param GroupInterface[] $groups
     */
    public function __construct(array $groups = [])
    {
        $this->groups = $groups;
    }

    public function has(string $groupName)
    {
        return isset($this->groups[$groupName]);
    }

    /**
     * @param $fieldName
     * @param $rule
     * @param $message
     */
    public function checkAndSet($fieldName, $rule, $message)
    {
        (!$this->has($fieldName)
         ? $this->create($fieldName)
         : $this->getGroup($fieldName))
         ->set($rule, $message);
    }

    /**
     * @param string $key
     * @param GroupInterface $group
     * @return GroupInterface
     */
    public function create(string $key, GroupInterface $group = null)
    {
        // Creation when it's really necessary
        if ($group === null) {
            $group = Group::create();
        }
        $this->setGroup($key, $group);
        return $group;
    }

    /**
     * @param string $groupName
     * @return GroupInterface the group of message
     */
    public function getGroup(string $groupName)
    {
        return $this->groups[$groupName] ?? null;
    }

    /**
     * @param string $groupName
     * @param GroupInterface $group
     */
    public function setGroup(string $groupName, GroupInterface $group)
    {
        $this->groups[$groupName] = $group;
    }

    /**
     * @return GroupInterface[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $toArray = [];
        foreach ($this->groups as $key => $group) {
            $toArray[$key] = $group->data();
        }
        return $toArray;
    }

    /**
     * @param GroupInterface[] $groups
     * @return DefaultMessageStorage|GroupInterface
     */
    public static function createInstance(array $groups = []) {
        return new self($groups);
    }
}