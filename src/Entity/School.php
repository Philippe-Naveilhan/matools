<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SchoolRepository::class)
 */
class School
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le nom de l'école.")
     * @Assert\Length(min=5, minMessage="Le nom de l'école doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=255, maxMessage="Le nom de l'école ne doit pas dépasser {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255, maxMessage="L'adresse de l'école ne peut excéder {{ limit }} caractères.")
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Assert\Length(
     *     max=5,
     *     min=5,
     *     maxMessage="Le code postal doit être de {{ limit }} caractères.")
     *     minMessage="Le code postal doit être de {{ limit }} caractères.")
     * @Assert\Regex("/^\d/")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="School")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Circo::class, inversedBy="schools")
     * @ORM\JoinColumn(nullable=false)
     */
    private $circo;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSchool($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSchool() === $this) {
                $user->setSchool(null);
            }
        }

        return $this;
    }

    public function getCirco(): ?Circo
    {
        return $this->circo;
    }

    public function setCirco(?Circo $circo): self
    {
        $this->circo = $circo;

        return $this;
    }
}
