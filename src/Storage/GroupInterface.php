<?php
namespace Validator\Storage;

/**
 * Interface GroupInterface
 * @package Validator\Storage
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
interface GroupInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value);


    /**
     * @param string $key
     * @return mixed
     */
    public function has(string $key);

    /**
     * @return mixed
     */
    public function data();

    /**
     * Returns the first error for this group
     * @return string error occurred
     */
    public function getHead();
}