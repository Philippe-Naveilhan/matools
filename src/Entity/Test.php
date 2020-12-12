<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraint as Assert;

class Test
{
    /**
     * @Assert\NotBlank(message = "faut remplir !")
     */
    private $firstname;

    /**
     * @Assert\NotBlank(message = "faut remplir !")
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
