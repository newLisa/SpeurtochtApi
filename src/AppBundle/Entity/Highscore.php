<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Highscore
 *
 * @ORM\Table(name="highscores")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HighscoreRepository")
 */
class Highscore
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
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

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
     * @var int
     *
     * @ORM\Column(name="markers_completed", type="integer")
     */
    private $markersCompleted;

    private $user;



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
     * Set score
     *
     * @param integer $score
     *
     * @return Highscore
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Highscore
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
     * @return Highscore
     */
    public function setQuestId($questId)
    {
        $this->questId = $questId;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getQuestId()
    {
        return $this->questId;
    }

    /**
     * Set markersCompleted
     *
     * @param integer $markersCompleted
     *
     * @return Highscore
     */
    public function setMarkersCompleted($markersCompleted)
    {
        $this->markersCompleted = $markersCompleted;
    }

    /**
     * Get markersCompleted
     *
     * @return int
     */
    public function getMarkersCompleted()
    {
        return $this->markersCompleted;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

     /** Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}

