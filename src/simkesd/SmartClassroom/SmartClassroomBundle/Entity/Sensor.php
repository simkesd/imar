<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sensor
 *
 * @ORM\Table(name="sensors")
 * @ORM\Entity
 */
class Sensor
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
     * @var integer
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Collection", inversedBy="sensors")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $collection;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="SensorValues", mappedBy="sensor")
     */
    private $sensorValues;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sensorValues = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Sensor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Sensor
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
     * Set collection
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Collection $collection
     * @return Sensor
     */
    public function setCollection(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Collection $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Collection 
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Add sensorValues
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\SensorValues $sensorValues
     * @return Sensor
     */
    public function addSensorValue(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\SensorValues $sensorValues)
    {
        $this->sensorValues[] = $sensorValues;

        return $this;
    }

    /**
     * Remove sensorValues
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\SensorValues $sensorValues
     */
    public function removeSensorValue(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\SensorValues $sensorValues)
    {
        $this->sensorValues->removeElement($sensorValues);
    }

    /**
     * Get sensorValues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSensorValues()
    {
        return $this->sensorValues;
    }
}
