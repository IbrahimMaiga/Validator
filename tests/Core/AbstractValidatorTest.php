<?php
namespace Validator\Tests\Core;

use PHPUnit\Framework\TestCase;
use Validator\Core\AbstractValidator;
use Validator\Exception\ValidationException;

/**
 * Class AbstractValidatorTest
 * @package Validator\Tests\Core
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */
class AbstractValidatorTest extends TestCase
{

    /**
     * @var AbstractValidator
     */
    private $validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->validator = new class extends AbstractValidator {};
    }

    public function testValidatorWithDefinedRules() {
        $this->validator->defineRules([
            'username' => 'required'
        ]);
        $this->assertTrue($this->validator->validate(['username' => 'Kanfa']));
    }

    public function testValidatorWithUnDefinedRules() {
        $this->assertFalse($this->validator->validate(['username' => 'Kanfa']));
    }

    public function  testValidatorExceptionWithDefineRules() {
        $this->expectException(ValidationException::class);
        $this->validator->defineRules([
            'username' => 'required',
            'password' => 'required'
        ]);
        $this->validator->validate(['username' => 'Kanfa']);
    }
}