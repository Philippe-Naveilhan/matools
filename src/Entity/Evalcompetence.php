<?php

namespace App\Entity;

use App\Repository\EvalcompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvalcompetenceRepository::class)
 */
class Evalcompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom de la compétence à enregistrer.")
     * @Assert\Length(max=255, maxMessage="L'intitulé de la compétence ne peut excéder {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Evalbloc::class, inversedBy="evalcompetences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloc;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="evalcompetences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @ORM\OneToMany(targetEntity=Competencestudent::class, mappedBy="evalcompetence", cascade={"persist", "remove"})
     */
    private $competencestudents;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placeorder;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $completion;


    public function __construct()
    {
        $this->competencestudents = new ArrayCollection();
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

    public function getBloc(): ?Evalbloc
    {
        return $this->bloc;
    }

    public function setBloc(?Evalbloc $bloc): self
    {
        $this->bloc = $bloc;

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
            $competencestudent->setEvalcompetence($this);
        }

        return $this;
    }

    public function removeCompetencestudent(Competencestudent $competencestudent): self
    {
        if ($this->competencestudents->removeElement($competencestudent)) {
            // set the owning side to null (unless already changed)
            if ($competencestudent->getEvalcompetence() === $this) {
                $competencestudent->setEvalcompetence(null);
            }
        }

        return $this;
    }

    public function getPlaceorder(): ?int
    {
        return $this->placeorder;
    }

    public function setPlaceorder(?int $placeorder): self
    {
        $this->placeorder = $placeorder;

        return $this;
    }

    public function getCompletion(): ?string
    {
        return $this->completion;
    }

    public function setCompletion(?string $completion): self
    {
        $this->completion = $completion;

        return $this;
    }
}
