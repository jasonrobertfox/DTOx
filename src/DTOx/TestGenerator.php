<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
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
