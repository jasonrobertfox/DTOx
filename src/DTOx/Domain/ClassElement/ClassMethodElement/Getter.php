<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain\ClassElement\ClassMethodElement;

use DTOx\Domain\ClassElement\ClassMethodElement;

/**
 * @package    DTOx\Domain\ClassElement\ClassMethodElement
 */
class Getter extends ClassMethodElement
{
    public function __construct($propertyName, $type)
    {
        $functionName = 'get'. ucfirst($propertyName);
        parent::__construct($functionName, 'public');
        $this->returns('string');
        $this->addBodyLine('return $this->'.$propertyName.';');
    }
}
