<?php
/**
 * Created by PhpStorm.
 * User: alexandru.turbatu
 * Date: 9/8/2018
 * Time: 5:14 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fridge")
 */
class Fridge
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=false}, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var FridgeInventory[]
     *
     * @ORM\OneToMany(targetEntity="FridgeInventory", mappedBy="fridgeId")
     */
    private $fridgeStuff;


    /**
     * @var ClientFridge[]
     *
     * @ORM\OneToMany(targetEntity="ClientFridge", mappedBy="fridgeId")
     */
    private $owners;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Fridge
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
     * @return Fridge
     */
    public function setOwners(array $owners)
    {
        $this->owners = $owners;
        return $this;
    }

    /**
     * @return FridgeInventory[]
     */
    public function getFridgeStuff(): array
    {
        return $this->fridgeStuff;
    }

    /**
     * @param FridgeInventory[] $fridgeStuff
     * @return Fridge
     */
    public function setFridgeStuff(array $fridgeStuff)
    {
        $this->fridgeStuff = $fridgeStuff;
        return $this;
    }
}
