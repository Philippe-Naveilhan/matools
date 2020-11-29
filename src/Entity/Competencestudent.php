<?php

namespace App\Entity;

use App\Repository\CompetencestudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity=Evalcompetence::class, inversedBy="competencestudents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evalcompetence;

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

    public function getEvalcompetence(): ?Evalcompetence
    {
        return $this->evalcompetence;
    }

    public function setEvalcompetence(?Evalcompetence $evalcompetence): self
    {
        $this->evalcompetence = $evalcompetence;

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
