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
class SimpleConstructor extends ClassMethodElement
{
    public function __construct($variables)
    {
        parent::__construct('__construct', 'public');
        foreach ($variables as $name => $type) {
            $this->addVariable($name, $type);
            $this->addBodyLine('$this->'.$name.' = $'.$name.';');
        }
    }
}
