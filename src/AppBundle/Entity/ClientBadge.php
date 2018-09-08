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
}