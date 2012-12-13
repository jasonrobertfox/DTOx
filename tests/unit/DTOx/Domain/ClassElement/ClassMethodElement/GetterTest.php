<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain\ClassElement\ClassMethodElement;

use DTOx\Domain\ClassElement\ClassMethodElement\Getter;

/**
 * @package    DTOx\Domain\ClassElement\ClassMethodElement
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
        $this->assertInstanceOf('DTOx\Domain\ClassElement\ClassMethodElement\Getter', $element, 'instance of');
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
