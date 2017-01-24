<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Koppel_tocht_locatie
 *
 * @ORM\Table(name="koppel_tocht_locatie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Koppel_tocht_locatieRepository")
 */
class Koppel_tocht_locatie
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
     *z
     * @ORM\Column(name="locatie_id", type="integer")
     */
    private $locatieId;


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
     * @return Koppel_tocht_locatie
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
     * Set locatieId
     *
     * @param integer $locatieId
     *
     * @return Koppel_tocht_locatie
     */
    public function setLocatieId($locatieId)
    {
        $this->locatieId = $locatieId;

        return $this;
    }

    /**
     * Get locatieId
     *
     * @return int
     */
    public function getLocatieId()
    {
        return $this->locatieId;
    }
}

