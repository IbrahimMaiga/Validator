<?php
namespace Validator\Tests\Storage;

use PHPUnit\Framework\TestCase;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\Group;
use Validator\Storage\MessageStorage;

/**
 * Class StorageTest
 * @package Validator\Tests\Storage
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class StorageTest extends TestCase
{

    /**
     * @var MessageStorage
     */
    private $storage;

    /**
     * @var array
     */
    private $groups;

    protected function setUp()
    {
        parent::setUp();
        $this->groups = [
            'username' => Group::create(),
            'password' => Group::create()
        ];
        $this->storage = new DefaultMessageStorage($this->groups);
    }

    public function testIsInstanceOfMessageStorage()
    {
        $this->assertInstanceOf(MessageStorage::class, $this->storage);
    }

    public function testStorageHas()
    {
        $this->assertTrue($this->storage->has('username'));
    }

    public function testStorageHasNot()
    {
        $this->assertFalse($this->storage->has('fakeKey'));
    }

    public function testGetGroups()
    {
        $this->assertEquals($this->storage->getGroups(), $this->groups);
    }

    public function testGetGroup()
    {
        $this->assertEquals($this->storage->getGroup('username'), $this->groups['username']);
    }

    public function testCreate()
    {
        $this->storage->create('required');
        $this->assertEquals(count($this->storage->getGroups()), 3);
        $this->assertContains('required', array_keys($this->storage->getGroups()));
    }

    public function testToArray()
    {
        $this->assertEquals($this->storage->toArray(), [
            'username' => [],
            'password' => [],
        ]);
    }

    public function testCheckAndSetIfKeyExist()
    {
        $group = Group::create(['min' => 'min error']);
        $storage = new DefaultMessageStorage(['username' => $group]);
        $storage->checkAndSet('username', 'max', 'max error');
        $this->assertTrue($storage->has('username'));
        $this->assertTrue($storage->getGroup('username')->has('max'));
    }

    public function testCheckAndSetIfKeyNotExist()
    {
        $group = Group::create(['min' => 'min error']);
        $storage = new DefaultMessageStorage(['username' => $group]);
        $storage->checkAndSet('password', 'max', 'max error');
        $this->assertTrue($storage->has('username'));
        $this->assertTrue($storage->has('password'));
        $this->assertFalse($storage->getGroup('username')->has('max'));
        $this->assertTrue($storage->getGroup('password')->has('max'));
    }
}