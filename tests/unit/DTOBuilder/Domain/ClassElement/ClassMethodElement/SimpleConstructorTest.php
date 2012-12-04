<?php
/**
 * DTOBuilder
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOBuilder\Domain\ClassElement\ClassMethodElement;

use DTOBuilder\Domain\ClassElement\ClassMethodElement\SimpleConstructor;

/**
 * @package    DTOBuilder\Domain\ClassElement\ClassMethodElement
 */
class SimpleConstructorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function validInitializeClassMethodElement()
    {
        $element = $this->getValidSimpleConstructor();
        $this->assertInstanceOf('DTOBuilder\Domain\ClassElement\ClassMethodElement\SimpleConstructor', $element, 'instance of');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethod()
    {
        $element = $this->getValidSimpleConstructor();
        $expected = '    /**
     * @param string $propOne
     * @param array $propTwo
     * @return void
     */
    public function __construct($propOne, $propTwo)
    {
        $this->propOne = $propOne;
        $this->propTwo = $propTwo;
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    private function getValidSimpleConstructor()
    {
        return new SimpleConstructor(array('propOne'=>'string', 'propTwo'=>'array'));
    }
}
