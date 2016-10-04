<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Speurtocht
 *
 * @ORM\Table(name="tocht")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpeurtochtRepository")
 */
class Speurtocht
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
     * @var string
     *
     * @ORM\Column(name="naam", type="string", length=255)
     */
    private $naam;

    /**
     * @var string
     *
     * @ORM\Column(name="opleiding", type="string", length=255)
     */
    private $opleiding;

    /**
     * @var string
     *
     * @ORM\Column(name="informatie", type="string", length=255)
     */
    private $informatie;


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
     * Set naam
     *
     * @param string $naam
     *
     * @return Speurtocht
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * Get naam
     *
     * @return string
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * Set opleiding
     *
     * @param string $opleiding
     *
     * @return Speurtocht
     */
    public function setOpleiding($opleiding)
    {
        $this->opleiding = $opleiding;

        return $this;
    }

    /**
     * Get opleiding
     *
     * @return string
     */
    public function getOpleiding()
    {
        return $this->opleiding;
    }

    /**
     * Set informatie
     *
     * @param string $informatie
     *
     * @return Speurtocht
     */
    public function setInformatie($informatie)
    {
        $this->informatie = $informatie;

        return $this;
    }

    /**
     * Get informatie
     *
     * @return string
     */
    public function getInformatie()
    {
        return $this->informatie;
    }
}

