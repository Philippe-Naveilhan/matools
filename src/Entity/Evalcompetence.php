<?php

namespace App\Entity;

use App\Repository\EvalcompetenceRepository;
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
}
