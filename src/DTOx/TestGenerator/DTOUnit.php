<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\TestGenerator;

use DTOx\Domain\CodeGenerator;
use DTOx\TestGenerator;
use DTOx\Domain\ClassFile;
use DTOx\Domain\ClassElement\ClassMethodElement\SimpleConstructor;
use DTOx\Domain\ClassElement\ClassMethodElement\Getter;
use DTOx\Domain\ClassElement\ClassPropertyElement;
use DTOx\Domain\ClassElement\ClassMethodElement;

/**
 * @package    DTOx\TestGenerator
 */
class DTOUnit extends CodeGenerator implements TestGenerator
{
    private $classFile = null;

    public function __construct($className, $classNameSpace, $variables)
    {
        $className = $this->cleanClassName($className);
        $classNameSpace = $this->cleanNameSpace($classNameSpace);

        $this->classFile = new ClassFile($className.'Test', $classNameSpace);
        $this->classNameSpace = $classNameSpace;
        $this->className = $className;
        $this->instanceName = lcfirst($className);
        $this->variables = $variables;
        $this->constantNames = array();
        foreach (array_keys($variables) as $name) {
            $constantName = strtoupper(implode('_', preg_split('/(?=[A-Z])/', $name)));
            $this->constantNames[$name] = array('constant' =>$constantName, 'name'=>$name);
        }
        $this->classFile->setParentClass('PHPUnit_Framework_TestCase');
        $this->classFile->addUseStatement($className, $classNameSpace);
        $this->addConstants();
        $this->initializeValid();
        $this->initializeNull();
        $this->successfulSystemSerialization();
        $this->successfulClassSerialization();
        $this->createPopulated();
    }

    /**
     * Returns an array of group names for use with annotation construction
     *
     * @return array
     */
    public function getTestGroups()
    {
        $rawGroups = explode('\\', $this->classNameSpace);
        $groups = array();
        $prior = 0;
        foreach ($rawGroups as $group) {
            $prefix = $prior > 0 ? $groups[$prior-1].'-' : '';
            $groups[] = $prefix . strtolower(substr(implode('-', preg_split('/(?=[A-Z])/', $group)), 1));
            $prior++;
        }
        return $groups;
    }

    private function addConstants()
    {
        foreach ($this->variables as $name => $value) {
            $this->classFile->addConstant('valid'.ucfirst($name), $value);
        }
    }

    private function initializeValid()
    {
        $element = new ClassMethodElement('initializeValid'.$this->className, 'public');
        $element->addBodyLine('$'.$this->instanceName.' = $this->createPopulated'.$this->className.'();');
        $element->addBodyLine('$this->assertInstanceOf(\''.$this->classNameSpace.'\\'.$this->className.'\', $'.$this->instanceName.', \'instanceOf\');');
        foreach ($this->constantNames as $name) {
            $element->addBodyLine('$this->assertEquals(self::VALID_'.$name['constant'].', $'.$this->instanceName.'->get'.ucfirst($name['name']).'(), \'get'.ucfirst($name['name']).'\');');
        }
        $this->addElement($element);
    }

    private function initializeNull()
    {
        $element = new ClassMethodElement('initializeNull'.$this->className, 'public');
        $element->addBodyLine('$'.$this->instanceName.' = new '.$this->className.'('.implode(', ', array_fill(0, count($this->variables), 'null')).');');
        $element->addBodyLine('$this->assertInstanceOf(\''.$this->classNameSpace.'\\'.$this->className.'\', $'.$this->instanceName.', \'instanceOf\');');
        foreach ($this->constantNames as $name) {
            $element->addBodyLine('$this->assertNull($'.$this->instanceName.'->get'.ucfirst($name['name']).'(), \'get'.ucfirst($name['name']).'\');');
        }
        $this->addElement($element);
    }

    private function successfulSystemSerialization()
    {
        $element = new ClassMethodElement('successfulSystemSerialization', 'public');
        $element->addBodyLine('$'.$this->instanceName.' = $this->createPopulated'.$this->className.'();');
        $element->addBodyLine('$serialized = serialize($'.$this->instanceName.');');
        $element->addBodyLine('$this->assertEquals($'.$this->instanceName.', unserialize($serialized), \'unserialize\');');
        $this->addElement($element);
    }

    private function successfulClassSerialization()
    {
        $element = new ClassMethodElement('successfulClassSerialization', 'public');
        $element->addBodyLine('$'.$this->instanceName.' = $this->createPopulated'.$this->className.'();');
        $element->addBodyLine('$serialized = $'.$this->instanceName.'->serialize();');
        $element->addBodyLine('$new'.$this->className.' = new '.$this->className.'('.implode(', ', array_fill(0, count($this->variables), 'null')).');');
        $element->addBodyLine('$new'.$this->className.'->unserialize($serialized);');
        $element->addBodyLine('$this->assertEquals($'.$this->instanceName.', $new'.$this->className.', \'unserialize\');');
        $this->addElement($element);
    }

    private function createPopulated()
    {
        $element = new ClassMethodElement('createPopulated'.$this->className, 'public');
        $element->returns($this->classNameSpace.'\\'.$this->className);
        $params = array();
        foreach ($this->constantNames as $name) {
            $params[] = 'self::VALID_'.$name['constant'];
        }
        $element->addBodyLine('return new '.$this->className.'('.implode(', ', $params).');');
        $this->addElement($element);
    }


    public function generate()
    {
        return $this->classFile->generate();
    }

    private function addElement($element)
    {
        $this->addTestAnnotations($element);
        $this->classFile->addElement($element);
    }

    private function addTestAnnotations(&$element)
    {
        $element->addAnnotation('test');
        $groups = $this->getTestGroups();
        foreach ($groups as $group) {
            $element->addAnnotation('group', $group);
        }
    }
}
