<?php

namespace App\Entity;

use App\Repository\EvalthemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvalthemeRepository::class)
 */
class Evaltheme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom du thème.")
     * @Assert\Length(max=255, maxMessage="L'intitulé du thème ne peut excéder {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Evalcategory::class, mappedBy="theme", cascade={"persist", "remove"})
     */
    private $evalcategories;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="evalthemes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    public function __construct()
    {
        $this->evalcategories = new ArrayCollection();
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
     * @return Collection|Evalcategory[]
     */
    public function getEvalcategories(): Collection
    {
        return $this->evalcategories;
    }

    public function addEvalcategory(Evalcategory $evalcategory): self
    {
        if (!$this->evalcategories->contains($evalcategory)) {
            $this->evalcategories[] = $evalcategory;
            $evalcategory->setTheme($this);
        }

        return $this;
    }

    public function removeEvalcategory(Evalcategory $evalcategory): self
    {
        if ($this->evalcategories->removeElement($evalcategory)) {
            // set the owning side to null (unless already changed)
            if ($evalcategory->getTheme() === $this) {
                $evalcategory->setTheme(null);
            }
        }

        return $this;
    }

    public function getEvaluation(): ?evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }
}
