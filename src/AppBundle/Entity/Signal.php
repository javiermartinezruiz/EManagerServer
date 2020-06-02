<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Signal
 *
 * @ORM\Table(name="signals")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SignalRepository")
 */
class Signal
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
     * @ORM\Column(name="phase", type="integer")
     */
    private $phase;

    /**
     * @var float
     *
     * @ORM\Column(name="active_power", type="float")
     */
    private $activePower;

    /**
     * @var float
     *
     * @ORM\Column(name="reactive_power", type="float")
     */
    private $reactivePower;

    /**
     * @var float
     *
     * @ORM\Column(name="apparent_power", type="float")
     */
    private $apparentPower;

    /**
     * @var float
     *
     * @ORM\Column(name="power_factor", type="float")
     */
    private $powerFactor;

    /**
     * @var float
     *
     * @ORM\Column(name="current", type="float")
     */
    private $current;

    /**
     * @var float
     *
     * @ORM\Column(name="voltage", type="float")
     */
    private $voltage;

    /**
     * @var float
     *
     * @ORM\Column(name="voltage_thd", type="float")
     */
    private $voltageThd;

    /**
     * @var float
     *
     * @ORM\Column(name="current_thd", type="float")
     */
    private $currentThd;

    /**
     * @var float
     *
     * @ORM\Column(name="crest_factor", type="float")
     */
    private $crestFactor;

    /**
     * @var float
     *
     * @ORM\Column(name="consumed_energy", type="float")
     */
    private $consumedEnergy;

    /**
     * @var float
     *
     * @ORM\Column(name="delivered_energy", type="float")
     */
    private $deliveredEnergy;

    /**
     * @var float
     *
     * @ORM\Column(name="phase_angle", type="float")
     */
    private $phaseAngle;

    /**
     * @ManyToOne(targetEntity="EnergyPoint")
     * @JoinColumn(name="energy_points_id", referencedColumnName="id")
     */
    private $energyPoint;

    /**
     * @ManyToOne(targetEntity="SignalGroup")
     * @JoinColumn(name="signal_groups_id", referencedColumnName="id")
     */
    private $signalGroup;


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
     * @return Signal
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
     * @return Signal
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
     * @return Signal
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
     * @return Signal
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
     * @return Signal
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
     * Set phase
     *
     * @param integer $phase
     * @return Signal
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;

        return $this;
    }

    /**
     * Get phase
     *
     * @return integer 
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Set activePower
     *
     * @param float $activePower
     * @return Signal
     */
    public function setActivePower($activePower)
    {
        $this->activePower = $activePower;

        return $this;
    }

    /**
     * Get activePower
     *
     * @return float 
     */
    public function getActivePower()
    {
        return $this->activePower;
    }

    /**
     * Set reactivePower
     *
     * @param float $reactivePower
     * @return Signal
     */
    public function setReactivePower($reactivePower)
    {
        $this->reactivePower = $reactivePower;

        return $this;
    }

    /**
     * Get reactivePower
     *
     * @return float 
     */
    public function getReactivePower()
    {
        return $this->reactivePower;
    }

    /**
     * Set apparentPower
     *
     * @param float $apparentPower
     * @return Signal
     */
    public function setApparentPower($apparentPower)
    {
        $this->apparentPower = $apparentPower;

        return $this;
    }

    /**
     * Get apparentPower
     *
     * @return float 
     */
    public function getApparentPower()
    {
        return $this->apparentPower;
    }

    /**
     * Set current
     *
     * @param float $current
     * @return Signal
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return float 
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set voltage
     *
     * @param float $voltage
     * @return Signal
     */
    public function setVoltage($voltage)
    {
        $this->voltage = $voltage;

        return $this;
    }

    /**
     * Get voltage
     *
     * @return float 
     */
    public function getVoltage()
    {
        return $this->voltage;
    }

    /**
     * Set voltageThd
     *
     * @param float $voltageThd
     * @return Signal
     */
    public function setVoltageThd($voltageThd)
    {
        $this->voltageThd = $voltageThd;

        return $this;
    }

    /**
     * Get voltageThd
     *
     * @return float 
     */
    public function getVoltageThd()
    {
        return $this->voltageThd;
    }

    /**
     * Set currentThd
     *
     * @param float $currentThd
     * @return Signal
     */
    public function setCurrentThd($currentThd)
    {
        $this->currentThd = $currentThd;

        return $this;
    }

    /**
     * Get currentThd
     *
     * @return float
     */
    public function getCurrentThd()
    {
        return $this->currentThd;
    }

    /**
     * Set crestFactor
     *
     * @param float $crestFactor
     * @return Signal
     */
    public function setCrestFactor($crestFactor)
    {
        $this->crestFactor = $crestFactor;

        return $this;
    }

    /**
     * Get crestFactor
     *
     * @return float 
     */
    public function getCrestFactor()
    {
        return $this->crestFactor;
    }

    /**
     * Set consumedEnergy
     *
     * @param float $consumedEnergy
     * @return Signal
     */
    public function setConsumedEnergy($consumedEnergy)
    {
        $this->consumedEnergy = $consumedEnergy;

        return $this;
    }

    /**
     * Get consumedEnergy
     *
     * @return float 
     */
    public function getConsumedEnergy()
    {
        return $this->consumedEnergy;
    }

    /**
     * Set deliveredEnergy
     *
     * @param float $deliveredEnergy
     * @return Signal
     */
    public function setDeliveredEnergy($deliveredEnergy)
    {
        $this->deliveredEnergy = $deliveredEnergy;

        return $this;
    }

    /**
     * Get deliveredEnergy
     *
     * @return float
     */
    public function getDeliveredEnergy()
    {
        return $this->deliveredEnergy;
    }

    /**
     * Set phaseAngle
     *
     * @param float $phaseAngle
     * @return Signal
     */
    public function setPhaseAngle($phaseAngle)
    {
        $this->phaseAngle = $phaseAngle;

        return $this;
    }

    /**
     * Get phaseAngle
     *
     * @return float 
     */
    public function getPhaseAngle()
    {
        return $this->phaseAngle;
    }


    /**
     * Get powerFactor
     *
     * @return float
     */
    public function getPowerFactor(){
        return $this->powerFactor;
    }


    /**
     * Set powerFactor
     *
     * @param $powerFactor
     * @return $this
     */
    public function setPowerFactor($powerFactor){
        $this->powerFactor = $powerFactor;
        return $this;
    }
    /**
     * Set energyPoint
     *
     * @param \stdClass $energyPoint
     * @return Signal
     */
    public function setEnergyPoint($energyPoint)
    {
        $this->energyPoint = $energyPoint;

        return $this;
    }

    /**
     * Get energyPoint
     *
     * @return \stdClass 
     */
    public function getEnergyPoint()
    {
        return $this->energyPoint;
    }

    /**
     * Set signalGroup
     *
     * @param \stdClass $signalGroup
     * @return Signal
     */
    public function setSignalGroup($signalGroup)
    {
        $this->signalGroup = $signalGroup;

        return $this;
    }

    /**
     * Get signalGroup
     *
     * @return \stdClass 
     */
    public function getSignalGroup()
    {
        return $this->signalGroup;
    }



}
