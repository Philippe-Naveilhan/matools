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
    const DOMAINS = [
        'ac-orleans-tours.fr',
        'ac-rennes.fr',
        'ac-rouen.fr',
        'ac-amiens.fr',
        'ac-lille.fr',
        'ac-reims.fr',
        'ac-nancy-metz.fr',
        'ac-strasbourg.fr',
        'ac-besancon.fr',
        'ac-dijon.fr',
        'ac-nantes.fr',
        'ac-poitiers.fr',
        'ac-limoges.fr',
        'ac-clermont.fr',
        'ac-lyon.fr',
        'ac-grenoble.fr',
        'ac-aix-marseille.fr',
        'ac-nice.fr',
        'ac-corse.fr',
        'ac-montpellier.fr',
        'ac-toulouse.fr',
        'ac-bordeaux.fr',
        'ac-mayotte.fr',
        'ac-guyane.fr',
        'ac-reunion.fr',
        'ac-guadeloupe.fr',
        'ac-martinique.fr',
        'ac-versailles.fr',
        'ac-paris.fr',
        'ac-creteil.fr',
        'ac-wf.wf',
        'ac-polynesie.pf',
        'ac-noumea.nc',
        'ac-spm.fr'
    ];

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
     * @Assert\Length(max=255, maxMessage="L'adresse ne peut faire plus de {{ limit }} caractères.")
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="Veuillez indiquer le code postal de cette académie.")
     * @Assert\Length(max=5, maxMessage="Le code postal ne peut dépasser {{ limit }} caractères.")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer la ville de l'académie.")
     * @Assert\Length(max=255, maxMessage="La ville ne peut faire plus de {{ limit }} caractères.")
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
