<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Domain;

use DTOx\Domain\ClassFile;
use DTOx\Domain\AbstractClassElement;
use Mockery;

/**
 * @package    DTOx\Domain
 */
class ClassFileTest extends \PHPUnit_Framework_TestCase
{
    const VALID_CLASS_NAME = "TestClass";
    const VALID_CLASS_NAMESPACE = "Application\Package";
    const VALID_PARENT_CLASS_NAME = "ParentClass";

    /**
     * @test
     * @group domain
     */
    public function returnValidGenerationTextForNullClassFile()
    {
        $classFile = $this->getValidClassFile();
        $expected = "<?php\nnamespace ". self::VALID_CLASS_NAMESPACE .";\n\n/**\n * @package ". self::VALID_CLASS_NAMESPACE."\n */\nclass ". self::VALID_CLASS_NAME."\n{\n}\n";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextWithExtends()
    {
        $classFile = $this->getValidClassFile();
        $classFile->setParentClass(self::VALID_PARENT_CLASS_NAME, self::VALID_CLASS_NAMESPACE);
        $expected = "<?php\nnamespace ". self::VALID_CLASS_NAMESPACE .";\n\nuse ".self::VALID_CLASS_NAMESPACE."\\".self::VALID_PARENT_CLASS_NAME.";\n\n/**\n * @package ". self::VALID_CLASS_NAMESPACE."\n */\nclass ". self::VALID_CLASS_NAME." extends ". self::VALID_PARENT_CLASS_NAME."\n{\n}\n";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextWithExtendsStdLib()
    {
        $classFile = $this->getValidClassFile();
        $classFile->setParentClass(self::VALID_PARENT_CLASS_NAME);
        $expected = "<?php\nnamespace ". self::VALID_CLASS_NAMESPACE .";\n\n/**\n * @package ". self::VALID_CLASS_NAMESPACE."\n */\nclass ". self::VALID_CLASS_NAME." extends \\". self::VALID_PARENT_CLASS_NAME."\n{\n}\n";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextWithGeneralUseStatements()
    {
        $classFile = $this->getValidClassFile();
        $classFile->addUseStatement(self::VALID_PARENT_CLASS_NAME, self::VALID_CLASS_NAMESPACE);
        $expected = "<?php\nnamespace ". self::VALID_CLASS_NAMESPACE .";\n\nuse ".self::VALID_CLASS_NAMESPACE."\\".self::VALID_PARENT_CLASS_NAME.";\n\n/**\n * @package ". self::VALID_CLASS_NAMESPACE."\n */\nclass ". self::VALID_CLASS_NAME."\n{\n}\n";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextWithAddImplementsStatement()
    {
        $classFile = $this->getValidClassFile();
        $classFile->addImplementsStatement(self::VALID_PARENT_CLASS_NAME, self::VALID_CLASS_NAMESPACE);
        $expected = "<?php\nnamespace ". self::VALID_CLASS_NAMESPACE .";\n\nuse ".self::VALID_CLASS_NAMESPACE."\\".self::VALID_PARENT_CLASS_NAME.";\n\n/**\n * @package ". self::VALID_CLASS_NAMESPACE."\n */\nclass ". self::VALID_CLASS_NAME." implements ". self::VALID_PARENT_CLASS_NAME."\n{\n}\n";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextWithAddImplementsStatementStandardLib()
    {
        $classFile = $this->getValidClassFile();
        $classFile->addImplementsStatement('Serializable');
        $expected = "<?php\nnamespace ". self::VALID_CLASS_NAMESPACE .";\n\n/**\n * @package ". self::VALID_CLASS_NAMESPACE."\n */\nclass ". self::VALID_CLASS_NAME." implements \Serializable\n{\n}\n";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextForUseExtendsAndImplments()
    {
        $classFile = $this->getValidClassFile();
        $classFile->setParentClass(self::VALID_PARENT_CLASS_NAME, self::VALID_CLASS_NAMESPACE);
        $classFile->addUseStatement('UseClass', 'UseClass\Namespace');
        $classFile->addImplementsStatement('ImplementsOne', 'Implements\Namespace\One');
        $classFile->addImplementsStatement('ImplementsTwo', 'Implements\Namespace\Two');
        $expected = "<?php
namespace Application\Package;

use Application\Package\ParentClass;
use UseClass\Namespace\UseClass;
use Implements\Namespace\One\ImplementsOne;
use Implements\Namespace\Two\ImplementsTwo;

/**
 * @package Application\Package
 */
class TestClass extends ParentClass implements ImplementsOne, ImplementsTwo
{
}
";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    /**
     * @test
     * @group domain
     */
    public function returnValidTextForElements()
    {
        $classFile = $this->getValidClassFile();
        $classFile->addElement($this->getMockClassElement());
        $expected = "<?php
namespace Application\Package;

/**
 * @package Application\Package
 */
class TestClass
{

    /**
     * @return void
     */
    protected function methodFunction()
    {
    }
}
";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

        /**
     * @test
     * @group domain
     */
    public function returnValidTextForClassConstants()
    {
        $classFile = $this->getValidClassFile();
        $classFile->addConstant('constantOne', 'valueOne');
        $classFile->addConstant('constantTwo', 20);
        $expected = "<?php
namespace Application\Package;

/**
 * @package Application\Package
 */
class TestClass
{
    const CONSTANT_ONE = 'valueOne';
    const CONSTANT_TWO = 20;
}
";
        $this->assertEquals($expected,$classFile->generate(), 'generate');
    }

    private function getValidClassFile()
    {
        return new ClassFile(self::VALID_CLASS_NAME, self::VALID_CLASS_NAMESPACE);
    }

    private function getMockClassElement()
    {
        $element = Mockery::mock('DTOx\Domain\AbstractClassElement');
        $expected = "    /**
     * @return void
     */
    protected function methodFunction()
    {
    }";
        $element->shouldReceive('generate')->andReturn($expected);
        return $element;
    }
}
