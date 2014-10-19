<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActuatorValues
 *
 * @ORM\Table(name="actuator_values")
 * @ORM\Entity(repositoryClass="simkesd\SmartClassroom\SmartClassroomBundle\Entity\ActuatorValuesRepository")
 */
class ActuatorValues
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
     * @ORM\ManyToOne(targetEntity="Actuator",inversedBy="actuator_values")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $actuator;

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
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $collection
     * @return ActuatorValues
     */
    public function setCollection(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator 
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
