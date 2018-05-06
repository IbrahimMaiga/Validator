<?php
namespace Validator\Storage;

/**
 * Interface MessageStorage
 * @package Validator\Storage
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
interface MessageStorage
{

    /**
     * @param string $key
     * @param GroupInterface $group
     * @return GroupInterface
     */
    public function create(string $key, GroupInterface $group = null);

    /**
     * @param string $groupName
     * @return mixed
     */
    public function has(string $groupName);

    /**
     * @param $fieldName
     * @param $rule
     * @param $message
     */
    public function checkAndSet($fieldName, $rule, $message);

    /**
     * @param string $group
     * @return Group the group of message
     */
    public function getGroup(string $group);

    /**
     * @param string $groupName
     * @param GroupInterface $group
     */
    public function setGroup(string $groupName, GroupInterface $group);

    /**
     * @return mixed
     */
    public function getGroups();

    /**
     * @return array
     */
    public function toArray();
}