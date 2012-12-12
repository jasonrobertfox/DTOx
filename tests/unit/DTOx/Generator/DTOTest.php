<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Generator;

use DTOx\Generator\DTO;

/**
 * @package    DTOx\Generator
 */
class DTOTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function validInitializeGenerator()
    {
        $generator = $this->getValidDTO();
        $this->assertInstanceOf('DTOx\Generator\DTO', $generator, 'instance of');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidCodeForSimpleDTO()
    {
        $generator = $this->getValidDTO();
        $expected = '<?php
namespace Company\Application;

/**
 * @package Company\Application
 */
class WidgetDTO implements \Serializable
{

    /**
     * @var string $id
     */
    private $id = null;

    /**
     * @var string $name
     */
    private $name = null;

    /**
     * @param string $id
     * @param string $name
     * @return void
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Serializable::serialize()
     * @return string
     */
    public function serialize()
    {
        $data = get_object_vars($this);
        return serialize($data);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Serializable::serialize()
     * @param string $data
     * @return void
     */
    public function unserialize($data)
    {
        $object = unserialize($data);
        foreach ($object as $variable => $value) {
            $this->$variable = $value;
        }
    }
}
';
        $this->assertEquals($expected, $generator->generate(), 'generate');
    }

    private function getValidDTO()
    {
        return new DTO('WidgetDTO', 'Company\Application', array('id'=>'string', 'name'=>'string'));
    }

}
