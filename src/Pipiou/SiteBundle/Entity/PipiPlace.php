<?php

namespace Pipiou\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PipiPlace
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pipiou\SiteBundle\Entity\PipiPlaceRepository")
 */
class PipiPlace
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Point
     *
     * @ORM\Column(name="position", type="point", nullable=true)
     */
    private $position;


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
     * @return PipiPlace
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
     * Set position
     *
     * @param point $position
     * @return PipiPlace
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return point 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
