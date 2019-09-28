<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 */
class Qqrq
{
    /**
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Id()
     *
     * @var Uuid
     */
    protected $id;


//    /**
//     * @ORM\Column(type="integer")
//     * @ORM\GeneratedValue()
//     * @ORM\Id()
//     *
//     * @var int
//     */
//    private $id;

    /**
     * @ORM\Column()
     * @var string
     */
    private $name;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Qqrq
    {
        $this->name = $name;
        return $this;
    }
}
