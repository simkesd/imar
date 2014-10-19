<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Collection
 *
 * @ORM\Table(name="collections")
 * @ORM\Entity(repositoryClass="simkesd\SmartClassroom\SmartClassroomBundle\Entity\CollectionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Collection
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
     * @ORM\Column(name="location_description", type="text")
     */
    private $locationDescription;


    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="Sensor", mappedBy="collection")
     */
    private $sensors;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="Actuator", mappedBy="collection")
     */
    private $actuators;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @ORM\PrePersist()
     */
    public function preUpload()
    {
        if ($this->file) {
            // do whatever you want to generate a unique name
            $this->setPath(uniqid().'.'.$this->file->guessExtension());
        }
    }

    /**
     * @ORM\PostPersist()
     */
    public function upload()
    {
        if (!$this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does automatically
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getFullPath()) {
            unlink($file);
        }
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sensors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actuators = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Collection
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
     * @return Collection
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
     * Set locationDescription
     *
     * @param string $locationDescription
     * @return Collection
     */
    public function setLocationDescription($locationDescription)
    {
        $this->locationDescription = $locationDescription;

        return $this;
    }

    /**
     * Get locationDescription
     *
     * @return string 
     */
    public function getLocationDescription()
    {
        return $this->locationDescription;
    }

    /**
     * Add sensors
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $sensors
     * @return Collection
     */
    public function addSensor(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $sensors)
    {
        $this->sensors[] = $sensors;

        return $this;
    }

    /**
     * Remove sensors
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $sensors
     */
    public function removeSensor(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor $sensors)
    {
        $this->sensors->removeElement($sensors);
    }

    /**
     * Get sensors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSensors()
    {
        return $this->sensors;
    }

    /**
     * Add actuators
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $actuators
     * @return Collection
     */
    public function addActuator(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $actuators)
    {
        $this->actuators[] = $actuators;

        return $this;
    }

    /**
     * Remove actuators
     *
     * @param \simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $actuators
     */
    public function removeActuator(\simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator $actuators)
    {
        $this->actuators->removeElement($actuators);
    }

    /**
     * Get actuators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActuators()
    {
        return $this->actuators;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Collection
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
}
