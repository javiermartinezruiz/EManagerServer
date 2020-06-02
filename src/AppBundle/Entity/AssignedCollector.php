<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * AssignedCollector
 *
 * @ORM\Table(name="assigned_collectors")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AssignedCollectorRepository")
 */
class AssignedCollector
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
     * @ManyToOne(targetEntity="EnergyPoint")
     * @JoinColumn(name="energy_points_id", referencedColumnName="id")
     */
    private $energyPoint;

    /**
     * @ManyToOne(targetEntity="Collector")
     * @JoinColumn(name="collectors_id", referencedColumnName="id")
     */
    private $collector;

    /**
     * @var boolean
     *
     * @ORM\Column(name="selected", type="boolean")
     */
    private $selected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="selected_date", type="datetime")
     */
    private $selectedDate;


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
     * Set energyPoint
     *
     * @param \stdClass $energyPoint
     * @return AssignedCollector
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
     * Set collector
     *
     * @param \stdClass $collector
     * @return AssignedCollector
     */
    public function setCollector($collector)
    {
        $this->collector = $collector;

        return $this;
    }

    /**
     * Get collector
     *
     * @return \stdClass 
     */
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * Set selected
     *
     * @param boolean $selected
     * @return AssignedCollector
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
     * Set selectedDate
     *
     * @param \DateTime $selectedDate
     * @return AssignedCollector
     */
    public function setSelectedDate($selectedDate)
    {
        $this->selectedDate = $selectedDate;

        return $this;
    }

    /**
     * Get selectedDate
     *
     * @return \DateTime 
     */
    public function getSelectedDate()
    {
        return $this->selectedDate;
    }
}
