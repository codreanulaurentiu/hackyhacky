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
 * @ORM\Table(name="client_fridges")
 */
class ClientFridge
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
     * @var  Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="ownedFridges")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $clientId;

    /**
     * @var  FridgeInventory
     *
     * @ORM\ManyToOne(targetEntity="FridgeInventory", inversedBy="owners")
     * @ORM\JoinColumn(name="fridge_id", referencedColumnName="id")
     */
    protected $fridgeId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ClientFridge
     */
    public function setId(int $id): ClientFridge
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClientId(): Client
    {
        return $this->clientId;
    }

    /**
     * @param Client $clientId
     * @return ClientFridge
     */
    public function setClientId(Client $clientId): ClientFridge
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return FridgeInventory
     */
    public function getFridgeId(): FridgeInventory
    {
        return $this->fridgeId;
    }

    /**
     * @param FridgeInventory $fridgeId
     * @return ClientFridge
     */
    public function setFridgeId(FridgeInventory $fridgeId): ClientFridge
    {
        $this->fridgeId = $fridgeId;
        return $this;
    }
}
