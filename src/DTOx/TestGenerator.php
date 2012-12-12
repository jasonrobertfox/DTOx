<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx;

/**
 * @package    DTOx
 */
interface TestGenerator
{
    /**
     * Returns an array of group names for use with annotation construction
     *
     * @return array
     */
    public function getTestGroups();
}
