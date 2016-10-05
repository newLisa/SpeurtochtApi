<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Koppel_tocht_vraag
 *
 * @ORM\Table(name="koppel_tocht_vraag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Koppel_tocht_vraagRepository")
 */
class Koppel_tocht_vraag
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
     * @ORM\Column(name="vraag_id", type="integer")
     */
    private $vraagId;


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
     * @return Koppel_tocht_vraag
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
     * Set vraagId
     *
     * @param integer $vraagId
     *
     * @return Koppel_tocht_vraag
     */
    public function setVraagId($vraagId)
    {
        $this->vraagId = $vraagId;

        return $this;
    }

    /**
     * Get vraagId
     *
     * @return int
     */
    public function getVraagId()
    {
        return $this->vraagId;
    }
}

