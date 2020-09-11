<?php

namespace App\Entity;

use App\Repository\CakesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CakesRepository::class)
 */
class Cakes
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
     * @ORM\Column(type="integer")
     */
    private $numPedido;

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
    

    public function getNumPedido(): ?int
    {
        return $this->numPedido;
    }

    public function setNumPedido(int $numPedido): self
    {
        $this->numPedido = $numPedido;

        return $this;
    }


}
