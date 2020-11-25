<?php

namespace App\Entity;

use App\Repository\AcademyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AcademyRepository::class)
 */
class Academy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le titre de l'académie")
     * @Assert\Length(min=10, minMessage="Le nom de l'académie doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=255, maxMessage="Le nom de l'académie ne doit pas dépasser {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez communiquer une adresse pour cette académie")
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="Veuillez indiquer le code postal de cette académie.")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer la ville de l'académie.")
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=District::class, mappedBy="inspection")
     */
    private $districts;

    public function __construct()
    {
        $this->districts = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|District[]
     */
    public function getDistricts(): Collection
    {
        return $this->districts;
    }

    public function addDistrict(District $district): self
    {
        if (!$this->districts->contains($district)) {
            $this->districts[] = $district;
            $district->setInspection($this);
        }

        return $this;
    }

    public function removeDistrict(District $district): self
    {
        if ($this->districts->removeElement($district)) {
            // set the owning side to null (unless already changed)
            if ($district->getInspection() === $this) {
                $district->setInspection(null);
            }
        }

        return $this;
    }
}
