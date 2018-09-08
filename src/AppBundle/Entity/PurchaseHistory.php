<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="purchase_history")
 */
class PurchaseHistory
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $itemId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="bought_at")
     */
    private $boughtAt;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer", name="quantity", nullable=true)
     */
    private $quantity;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer", name="price", nullable=true)
     */
    private $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PurchaseHistory
     */
    public function setId(int $id): PurchaseHistory
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItemId(): Item
    {
        return $this->itemId;
    }

    /**
     * @param Item $itemId
     * @return PurchaseHistory
     */
    public function setItemId(Item $itemId): PurchaseHistory
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBoughtAt(): \DateTime
    {
        return $this->boughtAt;
    }

    /**
     * @param \DateTime $boughtAt
     * @return PurchaseHistory
     */
    public function setBoughtAt(\DateTime $boughtAt): PurchaseHistory
    {
        $this->boughtAt = $boughtAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return PurchaseHistory
     */
    public function setQuantity(?int $quantity): PurchaseHistory
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return PurchaseHistory
     */
    public function setPrice(?int $price): PurchaseHistory
    {
        $this->price = $price;
        return $this;
    }
}