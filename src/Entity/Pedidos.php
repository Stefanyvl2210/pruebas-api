<?php

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidosRepository::class)
 */
class Pedidos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantCakes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantCakes(): ?int
    {
        return $this->cantCakes;
    }

    public function setCantCakes(int $cantCakes): self
    {
        $this->cantCakes = $cantCakes;

        return $this;
    }
}
