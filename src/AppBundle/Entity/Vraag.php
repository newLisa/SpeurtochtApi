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
     * @ORM\Column(name="answer_1", type="string", length=255)
     */
    private $answer_1;

     /**
     * @var string
     *
     * @ORM\Column(name="answer_2", type="string", length=255)
     */
    private $answer_2;

     /**
     * @var string
     *
     * @ORM\Column(name="answer_3", type="string", length=255)
     */
    private $answer_3;

     /**
     * @var string
     *
     * @ORM\Column(name="answer_4", type="string", length=255)
     */
    private $answer_4;

    /**
     * @var string
     *
     * @ORM\Column(name="correct_answer", type="string", length=255)
     */
    private $correct_answer;

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
     * Set answer_1
     *
     * @param string $answer_1
     *
     * @return Vraag
     */
    public function setAnswer_1($answer_1)
    {
        $this->answer_1 = $answer_1;

        return $this;
    }

    /**
     * Get answer_1
     *
     * @return string
     */
    public function getAnswer_1()
    {
        return $this->answer_1;
    }

    /**
     * Set answer_2
     *
     * @param string $answer_2
     *
     * @return Vraag
     */
    public function setAnswer_2($answer_2)
    {
        $this->answer_2 = $answer_2;

        return $this;
    }

    /**
     * Get answer_2
     *
     * @return string
     */
    public function getAnswer_2()
    {
        return $this->answer_2;
    }

     /**
     * Set answer_2
     *
     * @param string $answer_2
     *
     * @return Vraag
     */
    public function setAnswer_3($answer_3)
    {
        $this->answer_3 = $answer_3;

        return $this;
    }

    /**
     * Get answer_3
     *
     * @return string
     */
    public function getAnswer_3()
    {
        return $this->answer_3;
    }

     /**
     * Set answer_2
     *
     * @param string $answer_2
     *
     * @return Vraag
     */
    public function setAnswer_4($answer_4)
    {
        $this->answer_4 = $answer_4;

        return $this;
    }

    /**
     * Get answer_4
     *
     * @return string
     */
    public function getAnswer_4()
    {
        return $this->answer_4;
    }

    /**
     * Set correct_answer
     *
     * @param string $correct_answer
     *
     * @return Vraag
     */
    public function setCorrect_Answer($correct_answer)
    {
        $this->correct_answer = $correct_answer;

        return $this;
    }

    /**
     * Get correct_answer
     *
     * @return string
     */
    public function getCorrect_Answer()
    {
        return $this->correct_answer;
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

