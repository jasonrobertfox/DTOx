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
abstract class CodeGenerator
{

    protected function cleanClassName($className)
    {
        $words = explode('_', $className);
        if (count($words) > 1) {
            return implode('', array_map('ucwords', array_map('strtolower', $words)));
        } else {
            return ucfirst($words[0]);
        }
    }

    protected function cleanNameSpace($nameSpace)
    {
        return implode('\\', array_map(array($this, 'cleanClassName'), explode('\\', $nameSpace)));
    }

    /**
     * Returns a string containing php code
     *
     * @return string
     */
    abstract public function generate();
}
