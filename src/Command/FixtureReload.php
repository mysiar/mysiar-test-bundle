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

class FixtureReload extends Command
{
    private const ARG_FIXTURES_PATHS = 'fixtures-paths';
    private const OPT_FORCE = 'force';

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct(null);
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->setName('mysiar:fixtures:load')
            ->setDescription(
                'Loads Doctrine fixtures from given directories.'
            )
            ->setDefinition($this->createInputDefinition());
    }

    private function createInputDefinition(): InputDefinition
    {
        return new InputDefinition([
            new InputArgument(
                self::ARG_FIXTURES_PATHS,
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Collection of paths (separated by space) ' .
                'containing doctrine fixtures - e. g. "tests/Fixture"'
            ),
            new InputOption(self::OPT_FORCE, 'f', InputOption::VALUE_OPTIONAL, 'Force database erase', false)
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->executionConfirmed($input, $output)) {
            return 0;
        }

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->em, $purger);


        $paths = $input->getArgument(self::ARG_FIXTURES_PATHS);
        foreach ($paths as $path) {
            $loader = new Loader();
            $loader->loadFromDirectory($path);
            $executor->execute($loader->getFixtures());
            $output->write('Fixtures ');
            $output->write('<bg=green>' . $path . '</>');
            $output->writeln(' reloaded');
        }

        $output->writeln('<bg=yellow>All Fixtures reloaded.</>');
        return 0;
    }

    private function executionConfirmed(InputInterface $input, OutputInterface $output): bool
    {
        /** @var FormatterHelper $formatter */
        $formatter = $this->getHelper('formatter');
        if (false === $input->getOption(self::OPT_FORCE)) {
            $output->writeln($formatter->formatBlock(
                'Aborting. This command erase database. ' .
                'Provide --force option to prove you know what are you going to do.',
                'comment'
            ));
            return false;
        }
        if (OutputInterface::VERBOSITY_QUIET === $output->getVerbosity()) {
            return true;
        }
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Database will be erased. Continue? [y/n]', false);
        if (!$questionHelper->ask($input, $output, $question)) {
            $output->writeln($formatter->formatBlock('Canceled.', 'info'));

            return false;
        }

        return true;
    }
}
