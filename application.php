#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Eryx\Console\Command\ApacheSiteCreateCommand;

$application = new Application();
$application->add(new ApacheSiteCreateCommand());
$application->run();