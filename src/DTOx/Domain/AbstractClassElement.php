<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain;

use DTOx\Domain\CodeGenerator;

/**
 * @package    DTOx\Domain
 */
abstract class AbstractClassElement implements CodeGenerator
{

    /**
     * @var array
     */
    protected $lines = array();

    /**
     * @var array
     */
    protected $annotations = array();

    /**
     * @var array
     */
    protected $description = null;

    /**
     * @param string $annotation
     * @param string $content
     */
    public function addAnnotation($annotation, $content = null)
    {
        if (!is_null($content)) {
            $content = " ".$content;
        }
        $this->annotations[] = "@$annotation$content";
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $this->preGenerate();
        if (!empty($this->annotations) || !is_null($this->description)) {
            $this->lines[] = "/**";
            if (!is_null($this->description)) {
                $this->lines[] = " * $this->description";
                if (!empty($this->annotations)) {
                    $this->lines[] = " *";
                }
            }
            foreach ($this->annotations as $annotation) {
                $this->lines[] = " * $annotation";
            }
            $this->lines[] = " */";
        }
        $this->writeElementToLines();
        foreach ($this->lines as &$line) {
            $line = $line !== '' ? '    '.$line : '';
        }
        return implode("\n", $this->lines);
    }

    /**
     * Creates the lines for the element.
     *
     * @return void
     */
    abstract protected function writeElementToLines();

    /**
     * Run before generate function
     *
     * @return void
     */
    protected function preGenerate()
    {
    }
}
