<?php
/**
 * Created by PhpStorm.
 * User: xabier
 * Date: 29/11/14
 * Time: 20:56
 */

namespace Eryx\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * This class create a file config for one apache site
 * Class ApacheSiteCreateCommand
 * @package Eryx\Console\Command
 */
class ApacheSiteCreateCommand extends Command
{
    protected function configure()
    {
        $this->setName('eryx:apache:site:create');
        $this->setDescription('This command create new virtual host for apache');
        $this->addArgument('dommain')

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
