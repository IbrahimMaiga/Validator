<?php
namespace Validator\Tests\Rule;


use PHPUnit\Framework\TestCase;
use Validator\Rule\RequiredRule;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\MessageStorage;

/**
 * Class RequiredRuleTest
 * @package Validator\Tests\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class RequiredRuleTest extends TestCase
{


    /**
     * @var RequiredRule
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
        $this->rule = new RequiredRule($this->storage);
    }

    public function testDefineProcessPass()
    {
        $this->assertTrue($this->rule->evaluate('username', 'kanfa', ''));
    }

    public function testDefineProcessFailed()
    {
        $this->assertFalse($this->rule->evaluate('username', null, ''));
        $this->assertTrue($this->storage->has('username'));
    }
}