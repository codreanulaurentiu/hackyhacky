<?php
/**
 * Created by PhpStorm.
 * User: alexandru.turbatu
 * Date: 9/8/2018
 * Time: 5:19 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_badges")
 */
class ClientBadge
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
     * @var  int
     *
     *@ORM\Column(name="client_id", type="integer", options={"unsigned"=false}, nullable=false)
     */
    protected $client_id;

    /**
     * @var  int
     *
     *@ORM\Column(name="badge_id", type="smallint", options={"unsigned"=false}, nullable=false)
     */
    protected $badge_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

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
    public function getBadgeId(): int
    {
        return $this->badge_id;
    }

    /**
     * @param int $badge_id
     */
    public function setBadgeId(int $badge_id)
    {
        $this->badge_id = $badge_id;
    }


}