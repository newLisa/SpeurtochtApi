<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Koppel_tocht_user
 *
 * @ORM\Table(name="koppel_tocht_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Koppel_tocht_userRepository")
 */
class Koppel_tocht_user
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
     * @ORM\Column(name="tocht_id", type="integer")
     */
    private $tochtId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var bool
     *
     * @ORM\Column(name="started_bool", type="boolean", options={"default":true})
     */
    private $startedBool;

    /**
     * @var bool
     *
     * @ORM\Column(name="finished_bool", type="boolean", options={"default":false})
     */
    private $finishedBool;


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
     * Set tochtId
     *
     * @param integer $tochtId
     *
     * @return Koppel_tocht_user
     */
    public function setTochtId($tochtId)
    {
        $this->tochtId = $tochtId;

        return $this;
    }

    /**
     * Get tochtId
     *
     * @return int
     */
    public function getTochtId()
    {
        return $this->tochtId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Koppel_tocht_user
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
     * Set startedBool
     *
     * @param boolean $startedBool
     *
     * @return Koppel_tocht_user
     */
    public function setStartedBool($startedBool)
    {
        $this->startedBool = $startedBool;

        return $this;
    }

    /**
     * Get startedBool
     *
     * @return bool
     */
    public function getStartedBool()
    {
        return $this->startedBool;
    }

    /**
     * Set finishedBool
     *
     * @param boolean $finishedBool
     *
     * @return Koppel_tocht_user
     */
    public function setFinishedBool($finishedBool)
    {
        $this->finishedBool = $finishedBool;

        return $this;
    }

    /**
     * Get finishedBool
     *
     * @return bool
     */
    public function getFinishedBool()
    {
        return $this->finishedBool;
    }
}

