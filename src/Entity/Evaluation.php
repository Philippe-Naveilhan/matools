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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=Evalstudent::class, mappedBy="evaluation")
     */
    private $evalstudents;

    /**
     * @ORM\ManyToMany(targetEntity=Evalcompetence::class)
     */
    private $competence;

    public function __construct()
    {
        $this->evalstudents = new ArrayCollection();
        $this->competence = new ArrayCollection();
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

    public function getTeacher(): ?User
    {
        return $this->teacher;
    }

    public function setTeacher(?User $teacher): self
    {
        $this->teacher = $teacher;

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

    /**
     * @return Collection|Evalcompetence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Evalcompetence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Evalcompetence $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }
}
