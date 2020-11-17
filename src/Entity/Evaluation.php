<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Evalstudent::class, mappedBy="evaluation", cascade={"persist", "remove"})
     */
    private $evalstudents;

    /**
     * @ORM\ManyToOne(targetEntity=classroom::class, inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;

    /**
     * @ORM\OneToMany(targetEntity=Evalcompetence::class, mappedBy="evaluation", cascade={"persist", "remove"})
     */
    private $evalcompetences;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    public function __construct()
    {
        $this->evalstudents = new ArrayCollection();
        $this->competence = new ArrayCollection();
        $this->evalcompetences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Evalstudent[]
     */
    public function getEvalstudents(): Collection
    {
        return $this->evalstudents;
    }

    public function addEvalstudent(Evalstudent $evalstudent): self
    {
        if (!$this->evalstudents->contains($evalstudent)) {
            $this->evalstudents[] = $evalstudent;
            $evalstudent->setEvaluation($this);
        }

        return $this;
    }

    public function removeEvalstudent(Evalstudent $evalstudent): self
    {
        if ($this->evalstudents->removeElement($evalstudent)) {
            // set the owning side to null (unless already changed)
            if ($evalstudent->getEvaluation() === $this) {
                $evalstudent->setEvaluation(null);
            }
        }

        return $this;
    }

    public function getClassroom(): ?classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * @return Collection|Evalcompetence[]
     */
    public function getEvalcompetences(): Collection
    {
        return $this->evalcompetences;
    }

    public function addEvalcompetence(Evalcompetence $evalcompetence): self
    {
        if (!$this->evalcompetences->contains($evalcompetence)) {
            $this->evalcompetences[] = $evalcompetence;
            $evalcompetence->setEvaluation($this);
        }

        return $this;
    }

    public function removeEvalcompetence(Evalcompetence $evalcompetence): self
    {
        if ($this->evalcompetences->removeElement($evalcompetence)) {
            // set the owning side to null (unless already changed)
            if ($evalcompetence->getEvaluation() === $this) {
                $evalcompetence->setEvaluation(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }
}
