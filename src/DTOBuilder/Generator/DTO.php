<?php
/**
 * DTOBuilder
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOBuilder\Generator;

use DTOBuilder\Domain\CodeGenerator;
use DTOBuilder\Domain\ClassFile;
use DTOBuilder\Domain\ClassElement\ClassMethodElement\SimpleConstructor;
use DTOBuilder\Domain\ClassElement\ClassMethodElement\Getter;
use DTOBuilder\Domain\ClassElement\ClassPropertyElement;
use DTOBuilder\Domain\ClassElement\ClassMethodElement;

/**
 * @package    DTOBuilder\Generator
 */
class DTO implements CodeGenerator
{
    private $classFile = null;

    public function __construct($className, $classNameSpace, $variables)
    {
        $this->classFile = new ClassFile($className, $classNameSpace);
        $this->classFile->addImplementsStatement('Serializable');
        $this->addProperties($variables);
        $this->addConstructor($variables);
        $this->addGetters($variables);
        $this->addSerializeFunction();
        $this->addUnserializeFunction();
    }

    private function addConstructor($variables)
    {
        $element = new SimpleConstructor($variables);
        $this->classFile->addElement($element);
    }

    private function addProperties($variables)
    {
        foreach ($variables as $variable => $type) {
            $element = new ClassPropertyElement($variable, 'private', $type);
            $this->classFile->addElement($element);
        }
    }

    private function addGetters($variables)
    {
        foreach ($variables as $variable => $type) {
            $element = new Getter($variable, $type);
            $this->classFile->addElement($element);
        }
    }

    private function addSerializeFunction()
    {
        $element = new ClassMethodElement('serialize', 'public');
        $element->setDescription('(non-PHPdoc)');
        $element->addAnnotation('see', 'Serializable::serialize()');
        $element->returns('string');
        $element->addBodyLine('$data = get_object_vars($this);');
        $element->addBodyLine('return serialize($data);');
        $this->classFile->addElement($element);
    }

    private function addUnserializeFunction()
    {
        $element = new ClassMethodElement('unserialize', 'public');
        $element->setDescription('(non-PHPdoc)');
        $element->addAnnotation('see', 'Serializable::serialize()');
        $element->addVariable('data', 'string');
        $element->addBodyLine('$object = unserialize($data);');
        $element->addBodyLine('foreach ($object as $variable => $value) {');
        $element->addBodyLine('    $this->$variable = $value;');
        $element->addBodyLine('}');
        $this->classFile->addElement($element);
    }

    public function generate()
    {
        return $this->classFile->generate();
    }
}
