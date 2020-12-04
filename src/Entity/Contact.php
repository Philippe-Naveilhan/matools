<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\Length(max=100, maxMessage="Votre nom/identifiant doit être inférieur à {{ limit }} caractères")
     * @Assert\NotBlank(message="Merci de saisir votre prénom")
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Merci de saisir votre message")
     */
    private $message;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
