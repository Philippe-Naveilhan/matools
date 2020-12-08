<?php

namespace App\Entity;

use App\Repository\EvalcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvalcategoryRepository::class)
 */
class Evalcategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom du sou-thème.")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Evaltheme::class, inversedBy="evalcategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=Evalbloc::class, mappedBy="category", cascade={"persist", "remove"})
     */
    private $evalblocs;

    public function __construct()
    {
        $this->evalblocs = new ArrayCollection();
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

    public function getTheme(): ?Evaltheme
    {
        return $this->theme;
    }

    public function setTheme(?Evaltheme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|Evalbloc[]
     */
    public function getEvalblocs(): Collection
    {
        return $this->evalblocs;
    }

    public function addEvalbloc(Evalbloc $evalbloc): self
    {
        if (!$this->evalblocs->contains($evalbloc)) {
            $this->evalblocs[] = $evalbloc;
            $evalbloc->setCategory($this);
        }

        return $this;
    }

    public function removeEvalbloc(Evalbloc $evalbloc): self
    {
        if ($this->evalblocs->removeElement($evalbloc)) {
            // set the owning side to null (unless already changed)
            if ($evalbloc->getCategory() === $this) {
                $evalbloc->setCategory(null);
            }
        }

        return $this;
    }
}
