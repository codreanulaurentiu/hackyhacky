<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="food_waste_history")
 */
class FoodWasteHistory
{
    const OUT_OF_FRIDGE = 0;
    const IN_FRIDGE = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="type")
     */
    private $clientId;

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
     * @ORM\Column(type="datetime", name="wasted_at")
     */
    private $wastedAt;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer", length=200, name="name", nullable=true)
     */
    private $quantity;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer", length=200, name="external_ref", nullable=true)
     */
    private $wastedMoney;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FoodWasteHistory
     */
    public function setId(int $id): FoodWasteHistory
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     * @return FoodWasteHistory
     */
    public function setClientId(int $clientId): FoodWasteHistory
    {
        $this->clientId = $clientId;
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
     * @return FoodWasteHistory
     */
    public function setItemId(Item $itemId): FoodWasteHistory
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getWastedAt(): \DateTime
    {
        return $this->wastedAt;
    }

    /**
     * @param \DateTime $wastedAt
     * @return FoodWasteHistory
     */
    public function setWastedAt(\DateTime $wastedAt): FoodWasteHistory
    {
        $this->wastedAt = $wastedAt;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @param null|string $quantity
     * @return FoodWasteHistory
     */
    public function setQuantity(?string $quantity): FoodWasteHistory
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getWastedMoney(): ?string
    {
        return $this->wastedMoney;
    }

    /**
     * @param null|string $wastedMoney
     * @return FoodWasteHistory
     */
    public function setWastedMoney(?string $wastedMoney): FoodWasteHistory
    {
        $this->wastedMoney = $wastedMoney;
        return $this;
    }
}