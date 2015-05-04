<?php

namespace Pipiou\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PipiPlaceEvaluation
 *
 * @ORM\Table()
 * @ORM\Table(name="pipiplaceevaluation")
 * @ORM\Entity(repositoryClass="Pipiou\SiteBundle\Entity\PipiPlaceEvaluationRepository")
 */
class PipiPlaceEvaluation
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
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var integer
     *
     * @ORM\Column(name="cleanliness", type="integer")
     */
    private $cleanliness;

    /**
     * @var boolean
     *
     * @ORM\Column(name="door", type="boolean")
     */
    private $door;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paper", type="boolean")
     */
    private $paper;

    /**
     * @var boolean
     *
     * @ORM\Column(name="music", type="boolean")
     */
    private $music;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

     /**
     * @ORM\ManyToOne(targetEntity="Pipiou\UserBundle\Entity\User", inversedBy="place_evaluations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user_evaluator;

	/**
     * @ORM\ManyToOne(targetEntity="PipiPlace", inversedBy="evaluations")
     * @ORM\JoinColumn(name="pipiplace_id", referencedColumnName="id")
     */
    protected $place;

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
     * Set rating
     *
     * @param integer $rating
     * @return PipiPlaceEvaluation
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set cleanliness
     *
     * @param integer $cleanliness
     * @return PipiPlaceEvaluation
     */
    public function setCleanliness($cleanliness)
    {
        $this->cleanliness = $cleanliness;

        return $this;
    }

    /**
     * Get cleanliness
     *
     * @return integer 
     */
    public function getCleanliness()
    {
        return $this->cleanliness;
    }

    /**
     * Set door
     *
     * @param boolean $door
     * @return PipiPlaceEvaluation
     */
    public function setDoor($door)
    {
        $this->door = $door;

        return $this;
    }

    /**
     * Get door
     *
     * @return boolean 
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return PipiPlaceEvaluation
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set paper
     *
     * @param boolean $paper
     * @return PipiPlaceEvaluation
     */
    public function setPaper($paper)
    {
        $this->paper = $paper;

        return $this;
    }

    /**
     * Get paper
     *
     * @return boolean 
     */
    public function getPaper()
    {
        return $this->paper;
    }

    /**
     * Set music
     *
     * @param boolean $music
     * @return PipiPlaceEvaluation
     */
    public function setMusic($music)
    {
        $this->music = $music;

        return $this;
    }

    /**
     * Get music
     *
     * @return boolean 
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return PipiPlaceEvaluation
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set user_evaluator
     *
     * @param \Pipiou\UserBundle\Entity\User $userEvaluator
     * @return PipiPlaceEvaluation
     */
    public function setUserEvaluator(\Pipiou\UserBundle\Entity\User $userEvaluator = null)
    {
        $this->user_evaluator = $userEvaluator;

        return $this;
    }

    /**
     * Get user_evaluator
     *
     * @return \Pipiou\UserBundle\Entity\User 
     */
    public function getUserEvaluator()
    {
        return $this->user_evaluator;
    }

    /**
     * Set place
     *
     * @param \Pipiou\SiteBundle\Entity\PipiPlace $place
     * @return PipiPlaceEvaluation
     */
    public function setPlace(\Pipiou\SiteBundle\Entity\PipiPlace $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \Pipiou\SiteBundle\Entity\PipiPlace 
     */
    public function getPlace()
    {
        return $this->place;
    }
}
