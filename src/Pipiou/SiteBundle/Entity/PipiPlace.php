<?php

namespace Pipiou\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PipiPlace
 *
 * @ORM\Table(name="pipiplace")
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
     * @ORM\OneToMany(targetEntity="PipiPlaceEvaluation", mappedBy="place")
     */
    protected $evaluations;    

    /**
     * @ORM\ManyToOne(targetEntity="Pipiou\UserBundle\Entity\User", inversedBy="places_created")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user_creator;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getData(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'creator' => $this->getUserCreator()->getUsername()
        );
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

    /**
     * Add evaluations
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $evaluations
     * @return PipiPlace
     */
    public function addEvaluation(\Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $evaluations)
    {
        $this->evaluations[] = $evaluations;

        return $this;
    }

    /**
     * Remove evaluations
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $evaluations
     */
    public function removeEvaluation(\Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $evaluations)
    {
        $this->evaluations->removeElement($evaluations);
    }

    /**
     * Get evaluations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Set user_creator
     *
     * @param \Pipiou\UserBundle\Entity\User $userCreator
     * @return PipiPlace
     */
    public function setUserCreator(\Pipiou\UserBundle\Entity\User $userCreator = null)
    {
        $this->user_creator = $userCreator;

        return $this;
    }

    /**
     * Get user_creator
     *
     * @return \Pipiou\UserBundle\Entity\User 
     */
    public function getUserCreator()
    {
        return $this->user_creator;
    }
}
