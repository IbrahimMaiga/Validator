<?php

namespace Validator\Tests\Storage;

use PHPUnit\Framework\TestCase;
use Validator\Storage\Group;

/**
 * Class GroupTest
 * @package Validator\Tests\Storage
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class GroupTest extends TestCase
{
    /**
     * @var Group
     */
    private $group;

    /**
     * @var array
     */
    private $data;

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->data = [
            'min' => 'min error',
            'max' => 'max error',
        ];
        $this->group = new Group($this->data);
    }

    public function testIsInstanceOfGroupInterface()
    {
        $this->assertInstanceOf(Group::class, $this->group);
    }

    public function testGetHeadIfDataExist()
    {
        $this->assertEquals($this->group->getHead(), 'min error');
    }

    public function testGetHeadIfDataIsNone()
    {
        $this->assertNull(Group::create()->getHead());
    }

    public function testGetData()
    {
        $this->assertEquals($this->group->data(), $this->data);
    }

    public function testGetWithCorrectValue()
    {
        $this->assertEquals($this->group->get('max'), 'max error');
    }

    public function testGetWithIncorrectValue()
    {
        $this->assertNull($this->group->get('required'));
    }

    public function testSet()
    {
        $data = $this->data;
        $data['required'] = 'required error';
        $this->group->set('required', 'required error');
        $this->assertEquals($this->group->data(), $data);
    }

    public function testHasWithCorrectValue()
    {
        $this->assertTrue($this->group->has('min'));
    }

    public function testHasWithIncorrectValue()
    {
        $this->assertFalse($this->group->has('equals'));
    }
}