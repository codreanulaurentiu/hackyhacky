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
     * @var ClientFridge[]
     *
     * @ORM\OneToMany(targetEntity="ClientFridge", mappedBy="fridgeId")
     */
    private $owners;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FridgeInventory
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param Item $itemId
     * @return FridgeInventory
     */
    public function setItemId(Item $itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return FridgeInventory
     */
    public function setQuantity(?int $quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return FridgeInventory
     */
    public function setPrice(?int $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInitialQuantity()
    {
        return $this->initialQuantity;
    }

    /**
     * @param int|null $initialQuantity
     * @return FridgeInventory
     */
    public function setInitialQuantity(?int $initialQuantity)
    {
        $this->initialQuantity = $initialQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return FridgeInventory
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBoughtAt()
    {
        return $this->boughtAt;
    }

    /**
     * @param \DateTime $boughtAt
     * @return FridgeInventory
     */
    public function setBoughtAt(\DateTime $boughtAt)
    {
        $this->boughtAt = $boughtAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * @param \DateTime|null $removedAt
     * @return FridgeInventory
     */
    public function setRemovedAt(?\DateTime $removedAt)
    {
        $this->removedAt = $removedAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime|null $expiredAt
     * @return FridgeInventory
     */
    public function setExpiredAt(?\DateTime $expiredAt)
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }

    /**
     * @return ClientFridge[]
     */
    public function getOwners(): array
    {
        return $this->owners;
    }

    /**
     * @param ClientFridge[] $owners
     * @return FridgeInventory
     */
    public function setOwners(array $owners)
    {
        $this->owners = $owners;
        return $this;
    }
}
