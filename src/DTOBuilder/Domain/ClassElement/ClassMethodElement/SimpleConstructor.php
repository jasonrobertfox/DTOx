<?php
/**
 * DTOBuilder
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOBuilder\Domain\ClassElement\ClassMethodElement;

use DTOBuilder\Domain\ClassElement\ClassMethodElement;

/**
 * @package    DTOBuilder\Domain\ClassElement\ClassMethodElement
 */
class SimpleConstructor extends ClassMethodElement
{
    public function __construct($variables)
    {
        $functionName = 'get'. ucfirst($propertyName);
        parent::__construct('__construct', 'public');
        foreach ($variables as $name => $type) {
        $this->addVariable($name, $type);
        $this->addBodyLine('$this->'.$name.' = $'.$name.';');
        }
    }
}
