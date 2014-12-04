<?php
/**
 * Created by PhpStorm.
 * User: xabier
 * Date: 29/11/14
 * Time: 20:56
 */

namespace Eryx\Console\Command;

use Twig_Loader_Filesystem;
use Twig_Environment;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


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
        $this->addArgument('domain',InputArgument::REQUIRED,'Domain of application');
        $this->addArgument('application',InputArgument::REQUIRED,'');
        $this->addOption('apache-version','-a',InputOption::VALUE_OPTIONAL,'This option is the apache version','2.2.22');
        $this->addOption('environment-variables','-e',InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY,'List of environmentVariables');
        $this->addOption('apache-log-file','-f',InputOption::VALUE_OPTIONAL,'The path for apache log files','/var/log/apache2');
        $this->addOption('save-in-file','-s',InputOption::VALUE_OPTIONAL,'Save the config file in directory, put the directory',null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $domain = $input->getArgument('domain');
        $application = $input->getArgument('application');
        $apacheVersion = $input->getOption('apache-version');
        $environmentVariables = $input->getOption('environment-variables');
        $apacheLog = $input->getOption('apache-log-file');
        $saveInFile = $input->getOption('save-in-file');


        $output->writeln('<info>This config file for apache version: 2.2.22  </info>>');

        $configFile = $this->render($domain,$application,$apacheLog,$environmentVariables,$apacheVersion);

        if($saveInFile != null){
            $saveInFile = trim($saveInFile,'/');
            $file = DIRECTORY_SEPARATOR.$saveInFile.DIRECTORY_SEPARATOR.$domain. '.config';
            $fs = new Filesystem();
            try {
                $fs->dumpFile($file ,$configFile);

            } catch (IOExceptionInterface $e) {
                echo "An error occurred while save file in directory at ".$e->getPath();
            }
            $output->writeln('<info>Create config file in: '.$file.'</info>');
        }else{
            $output->writeln($configFile);
        }
    }

    private function render($domain,$application, $apacheLog, array $environmentVariables = null, $apacheVersion = '2.2.22')
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/templating');
        $twig = new Twig_Environment($loader, array());
        $application = trim($application,'/');
        $apacheLog = trim($apacheLog,'/');
        ld($environmentVariables);
        return $twig->render('apache.conf.twig',
            array(
                'domain' => $domain,
                'application'=>$application,
                'apacheLog' => $apacheLog,
                'environmentVariables' => $environmentVariables
            )
        );

    }
}
