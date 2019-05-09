<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Foo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column()
     * @var string
     */
    private $name;

    /**
     * @ORM\Column()
     * @var string
     */
    private $description;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name): Foo
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): Foo
    {
        $this->description = $description;
        return $this;
    }
}
