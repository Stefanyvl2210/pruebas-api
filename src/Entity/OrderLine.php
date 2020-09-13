<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderLineRepository::class)
 */
class OrderLine
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
    private $cake_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * OrderLine constructor.
     * @param $cake_id
     * @param $order_id
     * @param $amount
     */
    public function __construct($cake_id, $order_id, $amount)
    {
        $this->cake_id = $cake_id;
        $this->order_id = $order_id;
        $this->amount = $amount;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCakeId(): ?int
    {
        return $this->cake_id;
    }

    public function setCakeId(int $cake_id): self
    {
        $this->cake_id = $cake_id;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }

}
