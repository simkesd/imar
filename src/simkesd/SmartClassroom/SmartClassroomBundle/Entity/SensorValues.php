<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SensorValues
 *
 * @ORM\Table(name="sensor_values")
 * @ORM\Entity(repositoryClass="simkesd\SmartClassroom\SmartClassroomBundle\Entity\SensorValuesRepository")
 */
class SensorValues
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
     * @ORM\ManyToOne(targetEntity="Sensor", inversedBy="sensorValues")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $sensor;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;


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
     * Set collection
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $collection
     * @return SensorValues
     */
    public function setCollection(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor 
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return SensorValues
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set $sensor
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $sensor
     * @return SensorValues
     */
    public function setActuator(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $sensor = null)
    {
        $this->sensor = $sensor;

        return $this;
    }

    /**
     * Get $sensor
     *
     * @return \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor 
     */
    public function getActuator()
    {
        return $this->sensor;
    }
}
