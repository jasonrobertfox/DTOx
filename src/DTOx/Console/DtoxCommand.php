<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DTOx\Generator\DTO;
use DTOx\TestGenerator\DTOUnit;

/**
 * @package    DTOx\TestGenerator
 */
class DtoxCommand extends Command
{
    protected function configure()
    {
        $this->setName('react')
            ->setDescription('Start a new code reaction.')
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'What do you want to react?'
            )
            ->addArgument(
                'fqcn',
                InputArgument::REQUIRED,
                'Specify the fully qualified class name!'
            )
            ->addArgument(
                'variables',
                InputArgument::IS_ARRAY,
                'Specify your variables!'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $type = $input->getArgument('type');
        if (in_array(strtolower($type), array('dto','dto-unit'))) {
            $className = $this->getClassName($input->getArgument('fqcn'));
            $path = $this->getPath($input->getArgument('fqcn'));
            $output->writeln("Creating a new $type called $className in $path...");
            $text = $this->react(strtolower($type), $input->getArgument('fqcn'), $input->getArgument('variables'));
            $output->writeln($text);
        } else {
            throw new \RuntimeException('A formula for that reaction is not found!');
        }
    }

    private function getClassName($fqcn)
    {
        $exploded = explode('\\', $fqcn);
        return array_pop($exploded);
    }

    private function getNameSpace($fqcn)
    {
        return implode('\\', array_slice(explode('\\', $fqcn), 0, count(explode('\\', $fqcn))-1));
    }

    private function getPath($fqcn)
    {
        return implode('/', array_slice(explode('\\', $fqcn), 0, count(explode('\\', $fqcn))-1));
    }

    private function react($type, $fqcn, $variables)
    {
        $className = $this->getClassName($fqcn);
        $nameSpace = $this->getNameSpace($fqcn);
        $variablesArray = array();
        foreach ($variables as $variableString) {
            $parts = explode(':', $variableString);
            $variablesArray[$parts[1]] = $parts[0];
        }
        switch ($type) {
            case 'dto':
                $generator = new DTO($className, $nameSpace, $variablesArray);
                break;
            case 'dto-unit':
                $generator = new DTOUnit($className, $nameSpace, $variablesArray);
                $className.='Test';
                break;
            default:
                throw new \RuntimeException('A formula for that reaction is not found!');
        }
        $directory = getcwd() .'/'.$this->getPath($fqcn);
        if (is_dir($directory) && !is_writable($directory)) {
            $output->writeln(sprintf('The "%s" directory is not writable', $directory));
            return;
        }
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        file_put_contents($directory.'/'.$className.'.php', $generator->generate());
        return "Done!";
    }
}
