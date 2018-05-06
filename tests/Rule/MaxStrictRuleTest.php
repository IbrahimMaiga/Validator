<?php
namespace Validator\Tests\Rule;


use PHPUnit\Framework\TestCase;
use Validator\Rule\MaxStrictRule;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\MessageStorage;

/**
 * Class MaxStrictRuleTest
 * @package Validator\Tests\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MaxStrictRuleTest extends TestCase
{

    /**
     * @var MaxStrictRule
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
        $this->rule = new MaxStrictRule($this->storage);
    }

    public function testDefineProcessPass()
    {
        $this->assertTrue($this->rule->evaluate('username', 'kanfa', 6));
    }

    public function testDefineProcessFailed()
    {
        $this->assertFalse($this->rule->evaluate('username', 'kanfa', 5));
        $this->assertTrue($this->storage->has('username'));
    }
}