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
 * @Entity
 * @Table(name="client_fridges")
 */
class ClientFridge
{
    /**
     * @var  int
     *
     *@ORM\Column(name="client_id", type="integer", options={"unsigned"=false}, nullable=false)
     */
    protected $client_id;

    /**
     * @var  int
     *
     *@ORM\Column(name="fridge_id", type="integer", options={"unsigned"=false}, nullable=false)
     */
    protected $fridge_id;

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     */
    public function setClientId(int $client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return int
     */
    public function getFridgeId(): int
    {
        return $this->fridge_id;
    }

    /**
     * @param int $fridge_id
     */
    public function setFridgeId(int $fridge_id)
    {
        $this->fridge_id = $fridge_id;
    }


}