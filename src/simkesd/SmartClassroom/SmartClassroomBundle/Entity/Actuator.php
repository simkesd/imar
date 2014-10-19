<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actuator
 *
 * @ORM\Table(name="actuators")
 * @ORM\Entity(repositoryClass="simkesd\SmartClassroom\SmartClassroomBundle\Entity\ActuatorRepository")
 */
class Actuator
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
     * @ORM\ManyToOne(targetEntity="Collection", inversedBy="actuators")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $collection;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="ActuatorValues", mappedBy="actuators")
     */
    private $values;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->values = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Actuator
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
     * @return Actuator
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
     * @return Actuator
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
     * Add values
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\ActuatorValues $values
     * @return Actuator
     */
    public function addValue(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\ActuatorValues $values)
    {
        $this->values[] = $values;

        return $this;
    }

    /**
     * Remove values
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\ActuatorValues $values
     */
    public function removeValue(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\ActuatorValues $values)
    {
        $this->values->removeElement($values);
    }

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getValues()
    {
        return $this->values;
    }
}
