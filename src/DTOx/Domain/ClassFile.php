<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain;

use DTOx\Domain\CodeGenerator;

/**
 * @package    DTOx\Domain
 */
class ClassFile extends CodeGenerator
{
    private $lines = array('<?php');
    private $useStatements = array();
    private $implementsStatements = array();
    private $className = null;
    private $classNameSpace = null;
    private $parentClassName = null;
    private $parentClassNameSpace = null;
    private $elements = array();
    private $constants = array();

    /**
     * @param string $className
     * @param string $classNameSpace
     */
    public function __construct($className, $classNameSpace)
    {
        $this->className = $className;
        $this->classNameSpace = $classNameSpace;
    }

    /**
     * @param string $className
     * @param string $classNameSpace
     */
    public function setParentClass($className, $classNameSpace = null)
    {
        if (! is_null($classNameSpace)) {
            $this->addUseStatement($className, $classNameSpace);
            $this->parentClassName = $className;
        } else {
            $this->parentClassName = '\\'.$className;
        }
    }

    /**
     * @param string $className
     * @param string $classNameSpace
     */
    public function addUseStatement($className, $classNameSpace)
    {
        $this->useStatements[] = $classNameSpace.'\\'.$className;
    }

    /**
     * @param string $className
     * @param string $classNameSpace | null
     */
    public function addImplementsStatement($className, $classNameSpace = null)
    {
        if (! is_null($classNameSpace)) {
            $this->addUseStatement($className, $classNameSpace);
            $this->implementsStatements[] = $className;
        } else {
            $this->implementsStatements[] = '\\'.$className;
        }
    }

    public function addElement($element)
    {
        $this->elements[] = $element;
    }

    /**
     * Creates a constant from camel cased value
     *
     * @param string $name
     * @param string $value | null
     */
    public function addConstant($name, $value = null)
    {
        $constantName = strtoupper(implode('_', preg_split('/(?=[A-Z])/', $name)));
        if (is_numeric($value)) {
            $constantValue = $value;
        } elseif (is_null($value)) {
            $constantValue = "'null'";
        } else {
            $constantValue = "'$value'";
        }
        $this->constants[$constantName] = $constantValue;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $this->writeNameSpace()
            ->writeUseStatements()
            ->writeClassComment()
            ->writeClass()
            ->newLine();
        return implode("\n", $this->lines);
    }

    private function writeNameSpace()
    {
        $this->lines[] = "namespace $this->classNameSpace;";
        $this->newLine();
        return $this;
    }

    private function writeUseStatements()
    {
        if (!empty($this->useStatements)) {
            foreach ($this->useStatements as $statement) {
                $this->lines[] = "use $statement;";
            }
            $this->newLine();
        }
        return $this;
    }
    private function writeClassComment()
    {
        $this->startComment();
        $this->lines[] = " * @package $this->classNameSpace";
        $this->endComment();
        return $this;
    }

    private function writeClass()
    {

        $line = "class $this->className";
        if ($this->parentClassName) {
            $line .= " extends $this->parentClassName";
        }
        if (!empty($this->implementsStatements)) {
            $line .= " implements " . implode(", ", $this->implementsStatements);
        }
        $this->lines[] = $line;
        $this->lines[] = "{";
        if (!empty($this->constants)) {
            foreach ($this->constants as $name => $value) {
                $this->lines[] = '    const '.$name.' = '. $value.';';
            }
        }
        if (!empty($this->elements)) {
            foreach ($this->elements as $element) {
                $this->newLine();
                $this->lines[] = $element->generate();
            }
        }
        $this->lines[] = "}";
        return $this;
    }

    private function newLine()
    {
        $this->lines[] = "";
        return $this;
    }

    private function startComment()
    {
        $this->lines[] = "/**";
    }

    private function endComment()
    {
        $this->lines[] = " */";
    }
}
