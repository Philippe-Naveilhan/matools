<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\Length(max=100, maxMessage="Votre nom/identifiant doit être inférieur à {{ limit }} caractères")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message="Merci de saisir votre mail")
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Merci de saisir votre message")
     * @Assert\Length(max=1000, maxMessage="Votre message ne peut excéder {{ limit }} caractères.")
     */
    private $message;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
