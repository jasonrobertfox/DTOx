<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @package    DTOx\TestGenerator
 */
class DtoxCommandTest extends \PHPUnit_Framework_TestCase
{
    const VALID_REACT_TYPE = 'dto';
    const INVALID_REACT_TYPE = 'notavailable';
    const VALID_FULLY_QUALIFIED_CLASSNAME = 'SludgeCo\Acid\BurnyDTO';
    const VALID_VARIABLE = 'string:name';
    const VALID_VARIABLE_TWO = 'int:burnLevel';

    /**
     * @test
     * @group dto-builder
     * @group dto-builder-console
     * @expectedException \RuntimeException
     */
    public function throwExceptionForNoType()
    {
        $application = new Application();
        $application->add(new DtoxCommand());
        $command = $application->find('react');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName())
        );
    }

    /**
     * @test
     * @group dto-builder
     * @group dto-builder-console
     * @expectedException \RuntimeException
     * @expectedExceptionMessage A formula for that reaction is not found!
     */
    public function throwExceptionForNotExistingReaction()
    {
        $application = new Application();
        $application->add(new DtoxCommand());
        $command = $application->find('react');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName(), 'type' => self::INVALID_REACT_TYPE, 'fqcn'=> self::VALID_FULLY_QUALIFIED_CLASSNAME,'variables'=>array(self::VALID_VARIABLE, self::VALID_VARIABLE_TWO))
        );
    }
}
