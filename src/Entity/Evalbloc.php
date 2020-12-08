<?php

namespace App\Entity;

use App\Repository\EvalblocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvalblocRepository::class)
 */
class Evalbloc
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom de ce bloc de compétences.")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Evalcategory::class, inversedBy="evalblocs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Evalcompetence::class, mappedBy="bloc", cascade={"persist", "remove"})
     * @ORM\OrderBy ({"placeorder" = "ASC"})
     */
    private $evalcompetences;

    public function __construct()
    {
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

    public function getCategory(): ?Evalcategory
    {
        return $this->category;
    }

    public function setCategory(?Evalcategory $category): self
    {
        $this->category = $category;

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
            $evalcompetence->setBloc($this);
        }

        return $this;
    }

    public function removeEvalcompetence(Evalcompetence $evalcompetence): self
    {
        if ($this->evalcompetences->removeElement($evalcompetence)) {
            // set the owning side to null (unless already changed)
            if ($evalcompetence->getBloc() === $this) {
                $evalcompetence->setBloc(null);
            }
        }

        return $this;
    }
}
