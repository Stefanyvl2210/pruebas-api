<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cake", mappedBy="order")
     */
    private $cakes;

    /**
     * Order constructor.
     * @param $number
     */
    public function __construct($number=null)
    {
        $this->number = $number;
        $this->cakes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function addCake(Cake $cake){
        $this->cakes[] = $cake;
    }
    public function update(array $json) : self
    {
        $this->number = (isset($json['number'])) ? $json['number'] : $this->number;
        return $this;
    }
}
