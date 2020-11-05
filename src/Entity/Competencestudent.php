<?php

namespace App\Entity;

use App\Repository\CompetencestudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetencestudentRepository::class)
 */
class Competencestudent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evalstudent::class, inversedBy="competencestudents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evalstudent;

    /**
     * @ORM\ManyToOne(targetEntity=Evalcompetence::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $competence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvalstudent(): ?Evalstudent
    {
        return $this->evalstudent;
    }

    public function setEvalstudent(?Evalstudent $evalstudent): self
    {
        $this->evalstudent = $evalstudent;

        return $this;
    }

    public function getCompetence(): ?Evalcompetence
    {
        return $this->competence;
    }

    public function setCompetence(?Evalcompetence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
