<?php

namespace App\Entity;

use App\Repository\EvalcompetenceRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Evalbloc::class, inversedBy="evalcompetences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloc;

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
}
