<?php

namespace App\Entity;

use App\Repository\DistrictRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DistrictRepository::class)
 */
class District
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom de l'inspection académique.")
     * @Assert\Length(max=255, maxMessage="Le nom du département ne peut excéder {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Academy::class, inversedBy="districts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inspection;

    /**
     * @ORM\OneToMany(targetEntity=Circo::class, mappedBy="district")
     */
    private $circos;

    public function __construct()
    {
        $this->schools = new ArrayCollection();
        $this->circos = new ArrayCollection();
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

    public function getInspection(): ?Academy
    {
        return $this->inspection;
    }

    public function setInspection(?Academy $inspection): self
    {
        $this->inspection = $inspection;

        return $this;
    }

    /**
     * @return Collection|Circo[]
     */
    public function getCircos(): Collection
    {
        return $this->circos;
    }

    public function addCirco(Circo $circo): self
    {
        if (!$this->circos->contains($circo)) {
            $this->circos[] = $circo;
            $circo->setDistrict($this);
        }

        return $this;
    }

    public function removeCirco(Circo $circo): self
    {
        if ($this->circos->removeElement($circo)) {
            // set the owning side to null (unless already changed)
            if ($circo->getDistrict() === $this) {
                $circo->setDistrict(null);
            }
        }

        return $this;
    }
}
