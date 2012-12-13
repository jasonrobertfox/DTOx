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
class ClassPropertyElement extends AbstractClassElement
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
     * @var string $type
     */
    private $type = null;

    /**
     * @var string $defaultValue
     */
    private $defaultValue = 'null';

    public function __construct($name, $scope, $type)
    {
        $this->name = $name;
        $this->scope = $scope;
        $this->type = $type;
        $this->addAnnotation('var', $this->type.' $'.$this->name);
        if ($type == 'array') {
            $this->defaultValue = 'array()';
        }
    }

    protected function writeElementToLines()
    {
        $this->lines[] = $this->scope.' $'.$this->name.' = '.$this->defaultValue.';';
    }
}
