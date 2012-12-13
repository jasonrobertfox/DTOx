<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain\ClassElement;

use DTOx\Domain\AbstractClassElement;

/**
 * @package    DTOx\Domain
 */
class ClassMethodElement extends AbstractClassElement
{
    /**
     * @var string $name
     */
    private $name = null;

    /**
     * @var string $scope
     */
    private $scope = null;

    /**
     * @var string $static
     */
    private $static = null;

    /**
     * @var string $returnType
     */
    private $returnType = 'void';

    /**
     * @var array $variables
     */
    private $variables = array();

    /**
     * @var array $throws
     */
    private $throw = array();

    /**
     * @var array $bodyLines
     */
    private $bodyLines = array();

    public function __construct($name, $scope)
    {
        $this->name = $name;
        $this->scope = $scope;
    }

    public function makeStatic()
    {
        $this->static = " static";
    }

    /**
     * @param string $name
     * @param string $type
     */
    public function addVariable($name, $type)
    {
        $this->variables[] = '$'.$name;
        $this->addAnnotation('param', $type.' $'.$name);
    }

    /**
     * @param string $returnType
     */
    public function returns($returnType)
    {
        $this->returnType = $returnType;
    }

    /**
     * @param string $name
     */
    public function addThrows($name)
    {
        $this->throws[] = $name;
    }

    /**
     * @param string $line
     */
    public function addBodyLine($line)
    {
        $this->bodyLines[] = $line;
    }

    protected function preGenerate()
    {
        $this->addAnnotation('return', $this->returnType);
        if (!empty($this->throws)) {
            foreach ($this->throws as $throw) {
                $this->addAnnotation('throws', $throw);
            }
        }
    }

    protected function writeElementToLines()
    {
        $variables = empty($this->variables) ? '' : implode(', ', $this->variables);
        $this->lines[] = $this->scope."$this->static function ".$this->name."($variables)";
        $this->lines[] = '{';
        foreach ($this->bodyLines as &$line) {
            $this->lines[] = $line !== '' ? '    '.$line : '';
        }
        $this->lines[] = '}';
    }
}
