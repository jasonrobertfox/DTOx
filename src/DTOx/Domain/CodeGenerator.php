<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain;

/**
 * @package    DTOx\Domain
 */
interface CodeGenerator
{
    /**
     * Returns a string containing php code
     *
     * @return string
     */
    public function generate();
}
