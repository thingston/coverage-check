<?php

declare(strict_types=1);

namespace Thingston\Tests\Tools\Coverage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Thingston\Tools\Coverage\ApplicationFactory;
use Thingston\Tools\Coverage\Command\ProjectCheckCommand;

final class ApplicationTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testSuccessRun(): void
    {
        $application = ApplicationFactory::create();
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => ProjectCheckCommand::NAME,
            'path' => __DIR__ . '/coverage_valid.xml',
            '--quiet',
        ]);

        $result = $application->run($input);

        $this->assertSame(Command::SUCCESS, $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSuccessRunWithRelativePath(): void
    {
        $application = ApplicationFactory::create();
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => ProjectCheckCommand::NAME,
            'path' => 'tests/coverage_valid.xml',
            '--quiet',
        ]);

        $result = $application->run($input);

        $this->assertSame(Command::SUCCESS, $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidRun(): void
    {
        $application = ApplicationFactory::create();
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => ProjectCheckCommand::NAME,
            'path' => __DIR__ . '/coverage_invalid.xml',
            '--quiet',
        ]);

        $result = $application->run($input);

        $this->assertSame(Command::FAILURE, $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidRunWithBadRate(): void
    {
        $application = ApplicationFactory::create();
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => ProjectCheckCommand::NAME,
            'path' => __DIR__ . '/coverage_valid.xml',
            'rate' => 101,
            '--quiet',
        ]);

        $result = $application->run($input);

        $this->assertSame(Command::INVALID, $result);
    }
}
