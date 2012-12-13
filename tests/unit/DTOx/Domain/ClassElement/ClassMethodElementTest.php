<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain\ClassElement;

use DTOx\Domain\ClassElement\ClassMethodElement;

/**
 * @package    DTOx\Domain\ClassElement
 */
class ClassMethodElementTest extends \PHPUnit_Framework_TestCase
{
    const VALID_METHOD_SCOPE = 'protected';
    const VALID_METHOD_NAME = 'methodFunction';
    const VALID_DESCRIPTION = 'This is what the method does.';
    const VALID_RETURN_TYPE = 'string';

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function validInitializeClassMethodElement()
    {
        $element = $this->getValidClassMethodElement();
        $this->assertInstanceOf('DTOx\Domain\ClassElement\ClassMethodElement', $element, 'instance of');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethod()
    {
        $element = $this->getValidClassMethodElement();
        $expected = '    /**
     * @return void
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'()
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForStaticMethod()
    {
        $element = $this->getValidClassMethodElement();
        $element->makeStatic();
        $expected = '    /**
     * @return void
     */
    '.self::VALID_METHOD_SCOPE.' static function '.self::VALID_METHOD_NAME.'()
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethodWithDescription()
    {
        $element = $this->getValidClassMethodElement();
        $element->setDescription(self::VALID_DESCRIPTION);
        $expected = '    /**
     * '.self::VALID_DESCRIPTION.'
     *
     * @return void
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'()
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethodWithDescriptionAndVariable()
    {
        $element = $this->getValidClassMethodElement();
        $element->setDescription(self::VALID_DESCRIPTION);
        $element->addVariable('variableName', 'string');
        $expected = '    /**
     * '.self::VALID_DESCRIPTION.'
     *
     * @param string $variableName
     * @return void
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'($variableName)
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForMethodWithMultipleVariables()
    {
        $element = $this->getValidClassMethodElement();
        $element->addVariable('variableName', 'string');
        $element->addVariable('variableTwo', 'array');
        $expected = '    /**
     * @param string $variableName
     * @param array $variableTwo
     * @return void
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'($variableName, $variableTwo)
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethodWithReturn()
    {
        $element = $this->getValidClassMethodElement();
        $element->returns('string');
        $expected = '    /**
     * @return string
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'()
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethodThrowsException()
    {
        $element = $this->getValidClassMethodElement();
        $element->addThrows('Exception');
        $expected = '    /**
     * @return void
     * @throws Exception
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'()
    {
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethodWithBody()
    {
        $element = $this->getValidClassMethodElement();
        $element->addBodyLine('$variable = \'text\';');
        $expected = '    /**
     * @return void
     */
    '.self::VALID_METHOD_SCOPE.' function '.self::VALID_METHOD_NAME.'()
    {
        $variable = \'text\';
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    private function getValidClassMethodElement()
    {
        return new ClassMethodElement(self::VALID_METHOD_NAME, self::VALID_METHOD_SCOPE);
    }
}
