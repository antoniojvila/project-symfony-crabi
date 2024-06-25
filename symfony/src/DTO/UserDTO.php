<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class UserDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $first_name = null;

    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $last_name = null;

    // Getters y Setters...

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }
}