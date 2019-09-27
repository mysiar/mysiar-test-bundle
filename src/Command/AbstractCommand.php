<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Command;

use Mysiar\TestBundle\Helper\FixtureLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

abstract class AbstractCommand extends Command
{
    protected const NAME = '--- abstract ---';
    protected const DESCRIPTION = '--- abstract ---';
    protected const CONFIRMATION_QUESTION = '--- abstract ---';
    protected const END_MESSAGE = '--- abstract ---';

    /** @var FixtureLoader */
    protected $fixtureLoader;

    public function __construct(FixtureLoader $fixtureLoader)
    {
        parent::__construct(null);
        $this->fixtureLoader = $fixtureLoader;
    }

    protected function executionConfirmed(
        InputInterface $input,
        OutputInterface $output,
        string $confirmationQuestion
    ): bool {
        if (OutputInterface::VERBOSITY_QUIET === $output->getVerbosity()) {
            return true;
        }

        /**
         * @var QuestionHelper $helper
         */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion($confirmationQuestion, false);
        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<bg=blue>Canceled.</>');

            return false;
        }

        return true;
    }
}
