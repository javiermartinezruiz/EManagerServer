<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * AnnualCost
 *
 * @ORM\Table(name="annual_costs")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AnnualCostRepository")
 */
class AnnualCost
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
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var boolean
     *
     * @ORM\Column(name="selected", type="boolean")
     */
    private $selected;

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
     * @return AnnualCost
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
     * @return AnnualCost
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
     * @return AnnualCost
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
     * @return AnnualCost
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
     * @return AnnualCost
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
     * Set year
     *
     * @param integer $year
     * @return AnnualCost
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set selected
     *
     * @param boolean $selected
     * @return AnnualCost
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * Get selected
     *
     * @return boolean 
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * Set location
     *
     * @param \stdClass $location
     * @return AnnualCost
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \stdClass 
     */
    public function getLocation()
    {
        return $this->location;
    }
}
