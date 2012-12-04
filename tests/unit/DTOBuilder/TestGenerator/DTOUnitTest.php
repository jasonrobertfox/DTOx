<?php
/**
 * DTOBuilder
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOBuilder\TestGenerator;

use DTOBuilder\TestGenerator\DTOUnit;

/**
 * @package    DTOBuilder\TestGenerator
 */
class DTOUnitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function validInitializeTestGenerator()
    {
        $generator = $this->getValidDTOUnit();
        $this->assertInstanceOf('DTOBuilder\TestGenerator\DTOUnit', $generator, 'instance of');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidCodeForSimpleDTO()
    {
        $this->markTestIncomplete();
        $generator = $this->getValidDTOUnit();
        $expected = '';
        $this->assertEquals($expected, $generator->generate(), 'generate');
    }

    private function getValidDTOUnit()
    {
        return new DTOUnit('WidgetDTOTest', 'Company\Application', array('id'=>'string', 'name'=>'string'));
    }

}
