<?php
namespace Validator\Tests\Rule;

use PHPUnit\Framework\TestCase;
use Validator\Rule\EqualsRule;
use Validator\Storage\DefaultMessageStorage;
use Validator\Storage\MessageStorage;


/**
 * Class EqualsRuleTest
 * @package Validator\Tests\Rule
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class EqualsRuleTest extends TestCase
{

    /**
     * @var EqualsRule
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
        $this->rule = new EqualsRule($this->storage);
    }

    public function testDefineProcessPass()
    {
        $this->assertTrue($this->rule->evaluate('username', 'kanfa', 'kanfa'));
    }

    public function testDefineProcessFailed()
    {
        $this->assertFalse($this->rule->evaluate('username', 'kanfa', 'kanfaa'));
        $this->assertTrue($this->storage->has('username'));
    }
}