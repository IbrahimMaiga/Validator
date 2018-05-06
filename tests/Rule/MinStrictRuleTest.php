<?php

namespace Validator\Tests\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\MinStrictRule;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\MessageStorage;

/**
 * Class MinStrictRuleTest
 * @package Validator\Tests\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MinStrictRuleTest extends TestCase
{

    /**
     * @var MinStrictRule
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
        $this->rule = new MinStrictRule($this->storage);
    }

    public function testDefineProcessPass()
    {
        $this->assertTrue($this->rule->evaluate('username', 'kanfa', 4));
    }

    public function testDefineProcessFailed()
    {
        $this->assertFalse($this->rule->evaluate('username', 'kanfa', 5));
        $this->assertTrue($this->storage->has('username'));
    }
}