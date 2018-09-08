<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="clients")
 */
class Client
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
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var  int
     *
     *@ORM\Column(name="ext_id", type="integer", nullable=true)
     */
    protected $ext_id;

    /**
     * @var ClientFridge[]
     *
     * @ORM\OneToMany(targetEntity="ClientFridge", mappedBy="clientId")
     */
    private $ownedFridges;

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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
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
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getExtId(): int
    {
        return $this->ext_id;
    }

    /**
     * @param int $ext_id
     */
    public function setExtId(int $ext_id)
    {
        $this->ext_id = $ext_id;
    }

    /**
     * @return ClientFridge[]
     */
    public function getOwnedFridges(): array
    {
        return $this->ownedFridges;
    }

    /**
     * @param ClientFridge[] $ownedFridges
     * @return Client
     */
    public function setOwnedFridges(array $ownedFridges): Client
    {
        $this->ownedFridges = $ownedFridges;
        return $this;
    }
}
