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
     * @ORM\ManyToOne(targetEntity="Sensor",inversedBy="sensor_values")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $sensor;


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
}