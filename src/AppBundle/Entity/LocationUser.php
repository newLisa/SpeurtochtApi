<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationUser
 *
 * @ORM\Table(name="koppel_locatie_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationUserRepository")
 */
class LocationUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="locatie_id", type="integer")
     */
    private $location_id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

     /**
     * @var int
     *
     * @ORM\Column(name="quest_id", type="integer")
     */
    private $questId;

    /**
     * @var bool
     *
     * @ORM\Column(name="answered", type="boolean")
     */
    private $answered;

     /**
     * @var bool
     *
     * @ORM\Column(name="answered_correct", type="boolean")
     */
    private $answered_correct;

    private $user;

    private $location;

    private $quest;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set location_id
     *
     * @param integer $location_id
     *
     * @return LocationUser
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;

        return $this;
    }

    /**
     * Get location_id
     *
     * @return int
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return LocationUser
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set questId
     *
     * @param integer $questId
     *
     * @return LocationUser
     */
    public function setQuestId($questId)
    {
        $this->questId = $questId;

        return $this;
    }

    /**
     * Get questId
     *
     * @return int
     */
    public function getQuestId()
    {
        return $this->questId;
    }

    /**
     * Set answered_correct
     *
     * @param boolean $answered_correct
     *
     * @return LocationUser
     */
    public function setAnsweredCorrect($answered_correct)
    {
        $this->answered_correct = $answered_correct;

        return $this;
    }

    /**
     * Get answered_correct
     *
     * @return boolean
     */
    public function getAnsweredCorrect()
    {
        return $this->answered_correct;
    }

    /**
     * Set answered
     *
     * @param boolean $answered
     *
     * @return LocationUser
     */
    public function setAnswered($answered)
    {
        $this->answered = $answered;

        return $this;
    }

    /**
     * Get answered_correct
     *
     * @return boolean
     */
    public function getAnswered()
    {
        return $this->answered;
    }

    public function setLocation($locationArray)
    {
        $this->location = $locationArray;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setUser($userArray)
    {
        $this->user = $userArray;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setQuest($questArray)
    {
        $this->quest = $questArray;

        return $this;
    }

    public function getQuest()
    {
        return $this->quest;
    }
}

