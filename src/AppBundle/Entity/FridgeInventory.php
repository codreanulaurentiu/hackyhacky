<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fridge_inventory")
 */
class FridgeInventory
{
    const OUT_OF_FRIDGE = 0;
    const IN_FRIDGE     = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="fridge_id")
     */
    private $fridgeId;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $itemId;

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
     * @var null|int
     *
     * @ORM\Column(type="integer", name="initial_quantity")
     */
    private $initialQuantity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="status")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="bought_at")
     */
    private $boughtAt;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime", name="removed_at", nullable=true)
     */
    private $removedAt;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime", name="expired_at", nullable=true)
     */
    private $expiredAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FridgeInventory
     */
    public function setId(int $id): FridgeInventory
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFridgeId()
    {
        return $this->fridgeId;
    }

    /**
     * @param mixed $fridgeId
     * @return FridgeInventory
     */
    public function setFridgeId($fridgeId)
    {
        $this->fridgeId = $fridgeId;
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
     * @return FridgeInventory
     */
    public function setItemId(Item $itemId): FridgeInventory
    {
        $this->itemId = $itemId;
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
     * @return FridgeInventory
     */
    public function setQuantity(?int $quantity): FridgeInventory
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
     * @return FridgeInventory
     */
    public function setPrice(?int $price): FridgeInventory
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInitialQuantity(): ?int
    {
        return $this->initialQuantity;
    }

    /**
     * @param int|null $initialQuantity
     * @return FridgeInventory
     */
    public function setInitialQuantity(?int $initialQuantity): FridgeInventory
    {
        $this->initialQuantity = $initialQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return FridgeInventory
     */
    public function setStatus(int $status): FridgeInventory
    {
        $this->status = $status;
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
     * @return FridgeInventory
     */
    public function setBoughtAt(\DateTime $boughtAt): FridgeInventory
    {
        $this->boughtAt = $boughtAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getRemovedAt(): ?\DateTime
    {
        return $this->removedAt;
    }

    /**
     * @param \DateTime|null $removedAt
     * @return FridgeInventory
     */
    public function setRemovedAt(?\DateTime $removedAt): FridgeInventory
    {
        $this->removedAt = $removedAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpiredAt(): ?\DateTime
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime|null $expiredAt
     * @return FridgeInventory
     */
    public function setExpiredAt(?\DateTime $expiredAt): FridgeInventory
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }


}