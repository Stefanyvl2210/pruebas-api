<?php

namespace App\Entity;

use App\Repository\CakesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CakeRepository::class)
 * @ORM\Table(name="`cake`")
 */
class Cake
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Cake constructor.
     * @param $type
     * @param $price
     */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="cakes",cascade={"persist"})
     */
    private $order;

    public function __construct($type=null, $price=null)
    {
        $this->type = $type;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }


}
