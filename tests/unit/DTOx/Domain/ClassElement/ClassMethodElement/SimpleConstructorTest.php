<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain\ClassElement\ClassMethodElement;

use DTOx\Domain\ClassElement\ClassMethodElement\SimpleConstructor;

/**
 * @package    DTOx\Domain\ClassElement\ClassMethodElement
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
        $this->assertInstanceOf('DTOx\Domain\ClassElement\ClassMethodElement\SimpleConstructor', $element, 'instance of');
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
