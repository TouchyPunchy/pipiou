<?php

namespace Pipiou\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
	/**
	* @ORM\Column(name="id", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

   	/**
     * @ORM\OneToMany(targetEntity="Pipiou\SiteBundle\Entity\PipiPlace", mappedBy="user_creator")
     */
    protected $places_created;

	/**
     * @ORM\OneToMany(targetEntity="Pipiou\SiteBundle\Entity\PipiPlaceEvaluation", mappedBy="user_evaluator")
     */
    protected $place_evaluations;    

    public function __construct()
    {
        parent::__construct();
        $this->places_created = new ArrayCollection();
        $this->place_evaluations = new ArrayCollection();
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
     * Add places_created
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlace $placesCreated
     * @return User
     */
    public function addPlacesCreated(\Pipiou\SiteBundle\Entity\PipiPlace $placesCreated)
    {
        $this->places_created[] = $placesCreated;

        return $this;
    }

    /**
     * Remove places_created
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlace $placesCreated
     */
    public function removePlacesCreated(\Pipiou\SiteBundle\Entity\PipiPlace $placesCreated)
    {
        $this->places_created->removeElement($placesCreated);
    }

    /**
     * Get places_created
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlacesCreated()
    {
        return $this->places_created;
    }

    /**
     * Add place_evaluations
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $placeEvaluations
     * @return User
     */
    public function addPlaceEvaluation(\Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $placeEvaluations)
    {
        $this->place_evaluations[] = $placeEvaluations;

        return $this;
    }

    /**
     * Remove place_evaluations
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $placeEvaluations
     */
    public function removePlaceEvaluation(\Pipiou\SiteBundle\Entity\PipiPlaceEvaluation $placeEvaluations)
    {
        $this->place_evaluations->removeElement($placeEvaluations);
    }

    /**
     * Get place_evaluations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlaceEvaluations()
    {
        return $this->place_evaluations;
    }
}
