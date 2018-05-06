<?php
namespace Validator\Storage;

/**
 * Class Group
 * @package Validator\Storage
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class Group implements GroupInterface
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    public function has(string $key)
    {
        return isset($this->data[$key]);
    }

    public static function create(array $data = [])
    {
        return new self($data);
    }

    /**
     * @return array data
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Returns the first error for this group
     * @return string error occurred
     */
    public function getHead()
    {
        return array_values($this->data)[0] ?? null;
    }
}