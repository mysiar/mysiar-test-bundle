<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Command;

use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbList extends Command
{
    public const ENTITY_LENGTH = 100;
    public const COUNT_LENGTH = 10;
    public const LINE_FORMAT = '| %-' . self::ENTITY_LENGTH . 's | %' . self::COUNT_LENGTH . 's |';
    public const LINE_HORIZONTAL_LENGTH = 117;

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
            ->setName('mysiar:db:list')
            ->setDescription('List all entities and records count');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln(str_repeat('-', self::LINE_HORIZONTAL_LENGTH));
        $output->writeln(sprintf(self::LINE_FORMAT, 'Entity', 'Count'));
        $output->writeln(str_repeat('-', self::LINE_HORIZONTAL_LENGTH));
        // phpcs:enable
        foreach ($this->getEntityList() as $entity => $count) {
            $line = sprintf(
                self::LINE_FORMAT,
                '<fg=green>' . $this->formatString($entity, self::ENTITY_LENGTH) . '</>',
                '<fg=green>' . $this->formatString((string)$count, self::COUNT_LENGTH, true) . '</>'
            );
            $output->writeln($line);
        }
        $output->writeln(str_repeat('-', self::LINE_HORIZONTAL_LENGTH));
        return 0;
    }

    /**
     * @return string[]
     */
    private function getEntityList(): array
    {
        $entities = [];
        $metas = $this->em->getMetadataFactory()->getAllMetadata();

        $tables = $this->getTableNames();

        foreach ($metas as $meta) {
            $name = $meta->getName();
            $table = $this->em->getClassMetadata($name)->getTableName();

            if (in_array($table, $tables)) {
                $entities[$name] = $this->countEntityRecords($name);
            }
        }

        return $entities;
    }

    /**
     * @param string $className
     * @return mixed
     * @throws
     */
    private function countEntityRecords(string $className)
    {
        return current($this->em->createQueryBuilder()
            ->select('count(c.id)')
            ->from($className, 'c')
            ->getQuery()
            ->getSingleResult());
    }

    private function formatString(string $text, int $length, bool $right = false): string
    {
        $tl = strlen($text);
        for ($i = 0; $i < $length - $tl; $i++) {
            if ($right) {
                $text = " " . $text;
            } else {
                $text .= " ";
            }
        }

        return $text;
    }

    /**
     * @return string[]
     */
    private function getTableNames(): array
    {
        $simpleTableArray = [];
        $sm = $this->em->getConnection()->getSchemaManager();
        $tables = $sm->listTables();
        /** @var Table $table */
        foreach ($tables as $table) {
            $simpleTableArray[] = $table->getName();
        }

        return $simpleTableArray;
    }
}
