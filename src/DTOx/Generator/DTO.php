<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Generator;

use DTOx\Domain\CodeGenerator;
use DTOx\Domain\ClassFile;
use DTOx\Domain\ClassElement\ClassMethodElement\SimpleConstructor;
use DTOx\Domain\ClassElement\ClassMethodElement\Getter;
use DTOx\Domain\ClassElement\ClassPropertyElement;
use DTOx\Domain\ClassElement\ClassMethodElement;

/**
 * @package    DTOx\Generator
 */
class DTO extends CodeGenerator
{
    private $classFile = null;

    public function __construct($className, $classNameSpace, $variables)
    {

        $className = $this->cleanClassName($className);
        $classNameSpace = $this->cleanNameSpace($classNameSpace);

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
