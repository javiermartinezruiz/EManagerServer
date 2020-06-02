<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EnergyPoint
 *
 * @ORM\Table(name="energy_points")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EnergyPointRepository")
 */
class EnergyPoint
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @var string
     *
     * @ORM\Column(name="create_user", type="string", length=255)
     */
    private $createUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="write_date", type="datetime")
     */
    private $writeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="write_user", type="string", length=255)
     */
    private $writeUser;

    /**
     * @var string
     * @Assert\NotBlank(message="Verifique que el campo no sea nulo")
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="current_stat", type="string", length=10)
     */
    private $currentStat;

    /**
     * @ManyToOne(targetEntity="Location")
     * @JoinColumn(name="locations_id", referencedColumnName="id")
     */
    private $location;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return EnergyPoint
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return EnergyPoint
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set createUser
     *
     * @param string $createUser
     * @return EnergyPoint
     */
    public function setCreateUser($createUser)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return string 
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }

    /**
     * Set writeDate
     *
     * @param \DateTime $writeDate
     * @return EnergyPoint
     */
    public function setWriteDate($writeDate)
    {
        $this->writeDate = $writeDate;

        return $this;
    }

    /**
     * Get writeDate
     *
     * @return \DateTime 
     */
    public function getWriteDate()
    {
        return $this->writeDate;
    }

    /**
     * Set writeUser
     *
     * @param string $writeUser
     * @return EnergyPoint
     */
    public function setWriteUser($writeUser)
    {
        $this->writeUser = $writeUser;

        return $this;
    }

    /**
     * Get writeUser
     *
     * @return string 
     */
    public function getWriteUser()
    {
        return $this->writeUser;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return EnergyPoint
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EnergyPoint
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set currentStat
     *
     * @param string $currentStat
     * @return EnergyPoint
     */
    public function setCurrentStat($currentStat)
    {
        $this->currentStat = $currentStat;

        return $this;
    }

    /**
     * Get currentStat
     *
     * @return string 
     */
    public function getCurrentStat()
    {
        return $this->currentStat;
    }

    /**
     * Set location
     *
     * @param Location $location
     * @return EnergyPoint
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }
}
