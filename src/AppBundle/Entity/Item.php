<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item
{
    const ITEM_TYPE_STANDARD = 1;
    const ITEM_TYPE_BULK = 2;
    const ITEM_TYPE_CUSTOM = 3;
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
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="recommended_expire_date")
     */
    private $recommendedExpireDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, name="external_ref")
     */
    private $externalRef;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Item
     */
    public function setId(int $id): Item
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return Item
     */
    public function setType(int $type): Item
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRecommendedExpireDate(): \DateTime
    {
        return $this->recommendedExpireDate;
    }

    /**
     * @param \DateTime $recommendedExpireDate
     * @return Item
     */
    public function setRecommendedExpireDate(\DateTime $recommendedExpireDate): Item
    {
        $this->recommendedExpireDate = $recommendedExpireDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalRef(): string
    {
        return $this->externalRef;
    }

    /**
     * @param string $externalRef
     * @return Item
     */
    public function setExternalRef(string $externalRef): Item
    {
        $this->externalRef = $externalRef;
        return $this;
    }
}