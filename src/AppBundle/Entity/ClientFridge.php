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
     * @var  User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ownedFridges")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $clientId;

    /**
     * @var  Fridge
     *
     * @ORM\ManyToOne(targetEntity="Fridge", inversedBy="owners")
     * @ORM\JoinColumn(name="fridge_id", referencedColumnName="id")
     */
    protected $fridgeId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ClientFridge
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param User $clientId
     * @return ClientFridge
     */
    public function setClientId(User $clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return Fridge
     */
    public function getFridgeId()
    {
        return $this->fridgeId;
    }

    /**
     * @param Fridge $fridgeId
     * @return ClientFridge
     */
    public function setFridgeId(Fridge $fridgeId)
    {
        $this->fridgeId = $fridgeId;
        return $this;
    }
}
