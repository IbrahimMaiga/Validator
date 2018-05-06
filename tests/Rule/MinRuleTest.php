<?php

namespace Validator\Tests\Rule;


use PHPUnit\Framework\TestCase;
use Validator\Rule\MinRule;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\MessageStorage;

/**
 * Class MinRuleTest
 * @package Validator\Tests\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MinRuleTest extends TestCase
{
    /**
     * @var MinRule
     */
    private $rule;

    /**
     * @var MessageStorage
     */
    private $storage;

    public function setUp()
    {
        parent::setUp();
        $this->storage = DefaultMessageStorage::createInstance();
        $this->rule = new MinRule($this->storage);
    }

    public function testDefineProcessPass()
    {
        $this->assertTrue($this->rule->evaluate('username', 'kanfa', 4));
    }

    public function testDefineProcessFailed()
    {
        $this->assertFalse($this->rule->evaluate('username', 'kanfa', 6));
        $this->assertTrue($this->storage->has('username'));
    }
}