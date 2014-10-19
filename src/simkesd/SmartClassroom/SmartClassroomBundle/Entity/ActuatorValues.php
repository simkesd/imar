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
     * @ORM\ManyToOne(targetEntity="Actuator", inversedBy="actuatorValues")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $actuator;

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
     * Set actuator
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $actuator
     * @return ActuatorValues
     */
    public function setActuator(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $actuator = null)
    {
        $this->actuator = $actuator;

        return $this;
    }

    /**
     * Get actuator
     *
     * @return \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator 
     */
    public function getActuator()
    {
        return $this->actuator;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return ActuatorValues
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
}
