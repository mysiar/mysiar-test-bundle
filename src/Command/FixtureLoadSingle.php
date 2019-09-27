<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixtureLoadSingle extends AbstractCommand
{
    protected const NAME = 'mysiar:fixtures:single-load';
    protected const DESCRIPTION = 'Loads Doctrine single fixture file';
    protected const CONFIRMATION_QUESTION = 'Fixture will be added to existing database. Continue? [y/n]';
    protected const END_MESSAGE = '<bg=green>Fixture loaded.</>';

    private const ARG_FIXTURE_FILE = 'fixture-file';
    private const ARG_FIXTURE_FILE_DESCRIPTION = 'Single fixture file ' .
        'containing doctrine fixtures - e. g. "Fixture/FooFixture.php"';

    protected function configure(): void
    {
        $this
            ->setName(self::NAME)
            ->setDescription(
                self::DESCRIPTION
            )
            ->setDefinition($this->createInputDefinition());
    }

    private function createInputDefinition(): InputDefinition
    {
        return new InputDefinition([
            new InputArgument(
                self::ARG_FIXTURE_FILE,
                InputArgument::REQUIRED,
                self::ARG_FIXTURE_FILE_DESCRIPTION
            )
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->executionConfirmed($input, $output, self::CONFIRMATION_QUESTION)) {
            return 0;
        }

        $this->fixtureLoader->loadFixture($input->getArgument(self::ARG_FIXTURE_FILE));
        $output->writeln(self::END_MESSAGE);

        return 0;
    }
}
