<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class FixtureLoad extends AbstractCommand
{
    protected const NAME = 'mysiar:fixtures:load';
    protected const DESCRIPTION = 'Loads Doctrine fixtures from given directories.';
    protected const CONFIRMATION_QUESTION = 'Fixture will be added to existing database. Continue? [y/n]';
    protected const END_MESSAGE = '<bg=green>Fixture loaded.</>';

    private const ARG_FIXTURE_PATHS = 'fixtures-paths';
    private const ARG_FIXTURE_PATHS_DESCRIPTION = 'Collection of paths (separated by space) ' .
    'containing doctrine fixtures - e. g. "tests/Fixture"';

    private const OPT_FORCE = 'force';


    protected function configure(): void
    {
        $this
            ->setName(self::NAME)
            ->setDescription(self::DESCRIPTION)
            ->setDefinition($this->createInputDefinition());
    }

    private function createInputDefinition(): InputDefinition
    {
        return new InputDefinition([
            new InputArgument(
                self::ARG_FIXTURE_PATHS,
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                self::ARG_FIXTURE_PATHS_DESCRIPTION
            ),
            new InputOption(self::OPT_FORCE, 'f', InputOption::VALUE_OPTIONAL, 'Force database erase', false)
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->executionConfirmed($input, $output, self::CONFIRMATION_QUESTION)) {
            return 0;
        }

        $paths = $input->getArgument(self::ARG_FIXTURE_PATHS);
        $this->fixtureLoader->loadFixtures($paths);

        $output->writeln('<bg=yellow>All Fixtures reloaded.</>');
        return 0;
    }
}
