<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vraag
 *
 * @ORM\Table(name="vraag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VraagRepository")
 */
class Vraag
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
     * @ORM\Column(name="vraag", type="string", length=255)
     */
    private $vraag;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_id", type="string", length=255)
     */
    private $antwoord;

    /**
     * @var int
     *
     * @ORM\Column(name="punten", type="integer")
     */
    private $punten;

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
     * Set vraag
     *
     * @param string $vraag
     *
     * @return Vraag
     */
    public function setVraag($vraag)
    {
        $this->vraag = $vraag;

        return $this;
    }

    /**
     * Get vraag
     *
     * @return string
     */
    public function getVraag()
    {
        return $this->vraag;
    }

    /**
     * Set antwoord
     *
     * @param string $antwoord
     *
     * @return Vraag
     */
    public function setAntwoord($antwoord)
    {
        $this->antwoord = $antwoord;

        return $this;
    }

    /**
     * Get antwoord
     *
     * @return string
     */
    public function getAntwoord()
    {
        return $this->antwoord;
    }

    /**
     * Set punten
     *
     * @param integer $punten
     *
     * @return Vraag
     */
    public function setPunten($punten)
    {
        $this->punten = $punten;

        return $this;
    }

    /**
     * Get punten
     *
     * @return int
     */
    public function getPunten()
    {
        return $this->punten;
    }
}

