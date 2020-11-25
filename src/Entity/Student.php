<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le prénom de l'élève.")
     */
    private $Firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom de l'élève.")
     */
    private $Lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Birthday;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity=Evalstudent::class, mappedBy="student", orphanRemoval=true)
     */
    private $evalstudents;

    public function __construct()
    {
        $this->evalstudents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): self
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->Birthday;
    }

    public function setBirthday(?\DateTimeInterface $Birthday): self
    {
        $this->Birthday = $Birthday;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): ?self
    {
        $this->classroom = $classroom;

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
            $evalstudent->setStudent($this);
        }

        return $this;
    }

    public function removeEvalstudent(Evalstudent $evalstudent): self
    {
        if ($this->evalstudents->removeElement($evalstudent)) {
            // set the owning side to null (unless already changed)
            if ($evalstudent->getStudent() === $this) {
                $evalstudent->setStudent(null);
            }
        }

        return $this;
    }
}
