<?php

declare(strict_types=1);

namespace Thingston\Tools\Coverage\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thingston\Tools\Coverage\Clover\ProjectReport;
use Thingston\Tools\Coverage\Exception\InvalidArgumentException;

#[AsCommand(name: 'check:project')]
class ProjectCheckCommand extends Command
{
    public const NAME = 'check:project';

    protected static $defaultName = self::NAME;
    protected static $defaultDescription = 'Checks code coverage for the whole project.';

    protected function configure(): void
    {
        $this
            ->setHelp('Checks code coverage for the whole project.')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to XML file with Clover report.')
            ->addArgument('rate', InputArgument::OPTIONAL, 'Minimum coverage rate acceptable.', 90)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = is_string($input->getArgument('path')) ? $input->getArgument('path') : '';
        $rate = (int) (is_numeric($input->getArgument('rate')) ? $input->getArgument('rate') : 90);

        if (DIRECTORY_SEPARATOR !== substr($path, 0, 1)) {
            $path = getcwd() . DIRECTORY_SEPARATOR . $path;
        }

        if (0 > $rate || 100 < $rate) {
            $output->writeln(sprintf(
                '<error>Rate of %d%% is not valid; it must be between 0 and 100%%.</>',
                $rate
            ));

            return Command::INVALID;
        }

        $coverage = ProjectReport::fromPath($path)->getTotalProjectCoverage();

        if ($rate > $coverage) {
            $output->writeln(sprintf('<error> Total Project Coverage: %s%% (< %d%%) </>', $coverage, $rate));

            return Command::FAILURE;
        }

        $output->writeln(sprintf(
            '<bg=green;fg=black;options=bold> Total Project Coverage: %s%% (>= %d%%) </>',
            $coverage,
            $rate
        ));

        return Command::SUCCESS;
    }
}
