<?php

declare(strict_types=1);

namespace Thingston\Tools\Coverage;

use Symfony\Component\Console\Application;
use Thingston\Tools\Coverage\Command\ProjectCheckCommand;

class ApplicationFactory
{
    public static function create(): Application
    {
        $application = new Application('Thingston Coverage Check', '1.0.0');

        $application->add(new ProjectCheckCommand());

        return $application;
    }
}
