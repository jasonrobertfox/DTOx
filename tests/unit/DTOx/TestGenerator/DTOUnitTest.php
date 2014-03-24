<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\TestGenerator;

use DTOx\TestGenerator\DTOUnit;

/**
 * @package    DTOx\TestGenerator
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
        $this->assertInstanceOf('DTOx\TestGenerator\DTOUnit', $generator, 'instance of');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidGroupNamesForSimpleDTO()
    {
        $generator = $this->getValidDTOUnit();
        $groups = $generator->getTestGroups();
        $expected = array('company', 'company-application', 'company-application-camel-cased-name-space');
        $this->assertEquals($expected, $groups, 'get test groups');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidCodeForSimpleDTO()
    {
        $generator = $this->getValidDTOUnit();
        $this->assertEquals($this->validCodeOutput(), $generator->generate(), 'generate');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidCodeForRubyCaseDTOTest()
    {
        $generator = $this->getValidDTOUnitRubyCase();
        $this->assertEquals($this->validCodeOutput(), $generator->generate(), 'generate');
    }

    private function getValidDTOUnit()
    {
        return new DTOUnit('WidgetDTO', 'Company\Application\CamelCasedNameSpace', array('id'=>123, 'name'=>'John Doe'));
    }

    private function getValidDTOUnitRubyCase()
    {
        return new DTOUnit('widget_d_t_o', 'company\application\camel_cased_name_space', array('id'=>123, 'name'=>'John Doe'));
    }

    private function validCodeOutput()
    {
        return '<?php
namespace Company\Application\CamelCasedNameSpace;

use Company\Application\CamelCasedNameSpace\WidgetDTO;

/**
 * @package Company\Application\CamelCasedNameSpace
 */
class WidgetDTOTest extends \PHPUnit_Framework_TestCase
{
    const VALID_ID = 123;
    const VALID_NAME = \'John Doe\';

    /**
     * @test
     * @group company
     * @group company-application
     * @group company-application-camel-cased-name-space
     * @return void
     */
    public function initializeValidWidgetDTO()
    {
        $widgetDTO = $this->createPopulatedWidgetDTO();
        $this->assertInstanceOf(\'Company\Application\CamelCasedNameSpace\WidgetDTO\', $widgetDTO, \'instanceOf\');
        $this->assertEquals(self::VALID_ID, $widgetDTO->getId(), \'getId\');
        $this->assertEquals(self::VALID_NAME, $widgetDTO->getName(), \'getName\');
    }

    /**
     * @test
     * @group company
     * @group company-application
     * @group company-application-camel-cased-name-space
     * @return void
     */
    public function initializeNullWidgetDTO()
    {
        $widgetDTO = new WidgetDTO(null, null);
        $this->assertInstanceOf(\'Company\Application\CamelCasedNameSpace\WidgetDTO\', $widgetDTO, \'instanceOf\');
        $this->assertNull($widgetDTO->getId(), \'getId\');
        $this->assertNull($widgetDTO->getName(), \'getName\');
    }

    /**
     * @test
     * @group company
     * @group company-application
     * @group company-application-camel-cased-name-space
     * @return void
     */
    public function successfulSystemSerialization()
    {
        $widgetDTO = $this->createPopulatedWidgetDTO();
        $serialized = serialize($widgetDTO);
        $this->assertEquals($widgetDTO, unserialize($serialized), \'unserialize\');
    }

    /**
     * @test
     * @group company
     * @group company-application
     * @group company-application-camel-cased-name-space
     * @return void
     */
    public function successfulClassSerialization()
    {
        $widgetDTO = $this->createPopulatedWidgetDTO();
        $serialized = $widgetDTO->serialize();
        $newWidgetDTO = new WidgetDTO(null, null);
        $newWidgetDTO->unserialize($serialized);
        $this->assertEquals($widgetDTO, $newWidgetDTO, \'unserialize\');
    }

    /**
     * @test
     * @group company
     * @group company-application
     * @group company-application-camel-cased-name-space
     * @return Company\Application\CamelCasedNameSpace\WidgetDTO
     */
    public function createPopulatedWidgetDTO()
    {
        return new WidgetDTO(self::VALID_ID, self::VALID_NAME);
    }
}
';
    }


}
