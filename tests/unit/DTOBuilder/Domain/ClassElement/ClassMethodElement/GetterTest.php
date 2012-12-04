<?php
/**
 * DTOBuilder
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOBuilder\Domain\ClassElement\ClassMethodElement;

use DTOBuilder\Domain\ClassElement\ClassMethodElement\Getter;

/**
 * @package    DTOBuilder\Domain\ClassElement\ClassMethodElement
 */
class GetterTest extends \PHPUnit_Framework_TestCase
{
    const VALID_GETTER_VARIABLE = 'interestingProperty';

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function validInitializeClassMethodElement()
    {
        $element = $this->getValidGetter();
        $this->assertInstanceOf('DTOBuilder\Domain\ClassElement\ClassMethodElement\Getter', $element, 'instance of');
    }

    /**
     * @test
     * @group domain
     * @group domain-class-element
     */
    public function returnValidTextForBasicMethod()
    {
        $element = $this->getValidGetter();
        $expected = '    /**
     * @return string
     */
    public function getInterestingProperty()
    {
        return $this->interestingProperty;
    }';
        $this->assertEquals($expected, $element->generate(), 'generate');
    }

    private function getValidGetter()
    {
        return new Getter('interestingProperty', 'string');
    }
}
