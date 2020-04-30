<?php

declare(strict_types=1);

namespace App\Domain\User;

final class User
{
    private $id;

    private $email;

    private $password;

    private $optIn;

    private $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getOptIn(): bool
    {
        return $this->optIn;
    }

    public function setOptIn(bool $optIn): self
    {
        $this->optIn = $optIn;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'opt_in' => $this->getOptIn(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}