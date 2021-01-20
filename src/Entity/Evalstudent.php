<?php

namespace App\Entity;

use App\Repository\EvalstudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvalstudentRepository::class)
 */
class Evalstudent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="evalstudents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="evalstudents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255, maxMessage="Votre appréciation ne peut dépasser {{ limit }} caractères. Soyez concis !")
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=Competencestudent::class, mappedBy="evalstudent", orphanRemoval=true)
     */
    private $competencestudents;

    public function __construct()
    {
        $this->competencestudents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;

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

    /**
     * @return Collection|Competencestudent[]
     */
    public function getCompetencestudents(): Collection
    {
        return $this->competencestudents;
    }

    public function addCompetencestudent(Competencestudent $competencestudent): self
    {
        if (!$this->competencestudents->contains($competencestudent)) {
            $this->competencestudents[] = $competencestudent;
            $competencestudent->setEvalstudent($this);
        }

        return $this;
    }

    public function removeCompetencestudent(Competencestudent $competencestudent): self
    {
        if ($this->competencestudents->removeElement($competencestudent)) {
            // set the owning side to null (unless already changed)
            if ($competencestudent->getEvalstudent() === $this) {
                $competencestudent->setEvalstudent(null);
            }
        }

        return $this;
    }
}
