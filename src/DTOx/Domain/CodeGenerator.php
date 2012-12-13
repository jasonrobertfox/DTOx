<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
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
