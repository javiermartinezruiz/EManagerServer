<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SignalGroup
 *
 * @ORM\Table(name="signal_groups")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SignalGroupRepository")
 */
class SignalGroup
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
     * @var \DateTime
     *
     * @ORM\Column(name="collection_date", type="datetime")
     */
    private $collectionDate;

    /**
     * @var float
     *
     * @ORM\Column(name="frequency", type="float")
     */
    private $frequency;

    /**
     * @var float
     *
     * @ORM\Column(name="current_unbalance", type="float")
     */
    private $currentUnbalance;

    /**
     * @var float
     *
     * @ORM\Column(name="voltage_unbalance", type="float")
     */
    private $voltageUnbalance;


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
     * @return SignalGroup
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
     * @return SignalGroup
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
     * @return SignalGroup
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
     * @return SignalGroup
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
     * @return SignalGroup
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
     * Set collectionDate
     *
     * @param \DateTime $collectionDate
     * @return SignalGroup
     */
    public function setCollectionDate($collectionDate)
    {
        $this->collectionDate = $collectionDate;

        return $this;
    }

    /**
     * Get collectionDate
     *
     * @return \DateTime 
     */
    public function getCollectionDate()
    {
        return $this->collectionDate;
    }

    /**
     * Set frequency
     *
     * @param float $frequency
     * @return SignalGroup
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return float 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set currentUnbalance
     *
     * @param float $currentUnbalance
     * @return SignalGroup
     */
    public function setCurrentUnbalance($currentUnbalance)
    {
        $this->currentUnbalance = $currentUnbalance;

        return $this;
    }

    /**
     * Get currentUnbalance
     *
     * @return float 
     */
    public function getCurrentUnbalance()
    {
        return $this->currentUnbalance;
    }

    /**
     * Set voltageUnbalance
     *
     * @param float $voltageUnbalance
     * @return SignalGroup
     */
    public function setVoltageUnbalance($voltageUnbalance)
    {
        $this->voltageUnbalance = $voltageUnbalance;

        return $this;
    }

    /**
     * Get voltageUnbalance
     *
     * @return float
     */
    public function getVoltageUnbalance()
    {
        return $this->voltageUnbalance;
    }
}
