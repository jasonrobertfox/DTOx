<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
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
class DTOUnit implements CodeGenerator, TestGenerator
{
    private $classFile = null;

    public function __construct($className, $classNameSpace, $variables)
    {
        $this->classFile = new ClassFile($className.'Test', $classNameSpace);
        $this->classNameSpace = $classNameSpace;
        $this->className = $className;
        $this->variables = $variables;
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
        $element->addBodyLine('$'.$this->className.' = $this->createPopulated'.$this->className.'();');
        $element->addBodyLine('$this->assertInstanceOf(\''.$this->classNameSpace.'\\'.$this->className.'\', $'.$this->className.', \'instanceOf\');');

        foreach ($this->variables as $name => $value) {
            $constantName = strtoupper(implode('_', preg_split('/(?=[A-Z])/', $name)));
            $element->addBodyLine('$this->assertEquals(self::VALID_'.$constantName.', $'.$this->className.'->get'.ucfirst($name).'(), \'get'.ucfirst($name).'\');');
        }
        $this->addElement($element);
    }

    private function initializeNull()
    {
        $element = new ClassMethodElement('initializeNull'.$this->className, 'public');
        $element->addBodyLine('$'.$this->className.' = new'.$this->className.'('.implode(', ', array_fill(0, count($this->variables), 'null')).');');
        $element->addBodyLine('$this->assertInstanceOf(\''.$this->classNameSpace.'\\'.$this->className.'\', $'.$this->className.', \'instanceOf\');');
        foreach ($this->variables as $name => $value) {
            $constantName = strtoupper(implode('_', preg_split('/(?=[A-Z])/', $name)));
            $element->addBodyLine('$this->assertNull($'.$this->className.'->get'.ucfirst($name).'(), \'get'.ucfirst($name).'\');');
        }
        $this->addElement($element);
    }

    private function successfulSystemSerialization()
    {
        $element = new ClassMethodElement('successfulSystemSerialization', 'public');
        $element->addBodyLine('$'.$this->className.' = $this->creatPopulated'.$this->className.'();');
        $element->addBodyLine('serialized = serialize($'.$this->className.');');
        $element->addBodyLine('$this->assertEquals($'.$this->className.', unserialize($serialized), \'unserialize\');');
        $this->addElement($element);
    }

    private function successfulClassSerialization()
    {
        $element = new ClassMethodElement('successfulClassSerialization', 'public');
        $element->addBodyLine('$'.$this->className.' = $this->creatPopulated'.$this->className.'();');
        $element->addBodyLine('$serialized = $'.$this->className.'->serialize();');
        $element->addBodyLine('$new'.$this->className.' = new'.$this->className.'('.implode(', ', array_fill(0, count($this->variables), 'null')).');');
        $element->addBodyLine('$new'.$this->className.'->unserialize($serialized);');
        $element->addBodyLine('$this->assertEquals($'.lcfirst($this->className).', $new'.$this->className.', \'unserialize\');');
        $this->addElement($element);
    }

    private function createPopulated()
    {
        $element = new ClassMethodElement('createPopulated'.$this->className, 'public');
        $element->returns($this->classNameSpace.'\\'.$this->className);
        $params = array();
        foreach ($this->variables as $name => $value) {
            $constantName = strtoupper(implode('_', preg_split('/(?=[A-Z])/', $name)));
            $params[] = 'self::VALID_'.$constantName;
        }
        $element->addBodyLine('return $'.lcfirst($this->className).' = new '.$this->className.'('.implode(', ', $params).');');
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
