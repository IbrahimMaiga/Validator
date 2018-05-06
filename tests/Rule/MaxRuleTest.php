<?php
namespace Validator\Tests\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\MaxRule;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\MessageStorage;

/**
 * Class MaxRuleTest
 * @package Validator\Tests\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class MaxRuleTest extends TestCase
{

    /**
     * @var MaxRule
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
        $this->rule = new MaxRule($this->storage);
    }

    public function testDefineProcessPass()
    {
        $this->assertTrue($this->rule->evaluate('username', 'kanfa', 5));
    }

    public function testDefineProcessFailed()
    {
        $this->assertFalse($this->rule->evaluate('username', 'kanfa', 3));
        $this->assertTrue($this->storage->has('username'));
    }
}