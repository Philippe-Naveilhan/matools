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
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Evalcategory::class, mappedBy="theme")
     */
    private $evalcategories;

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
}
