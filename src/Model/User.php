<?php

namespace App\Model;

class User
{
    private ?int $id = null;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;

    // --- GETTER ---
    public function getId(): ?int { return $this->id; }
    public function getFirstName(): string { return $this->first_name; }
    public function getLastName(): string { return $this->last_name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }

    public function getFullName(): string {
        return $this->first_name . ' ' . $this->last_name;
    }

    // --- SETTER ---
    public function setId(int $id): void { $this->id = $id; }
    public function setFirstName(string $first_name): void { $this->first_name = $first_name; }
    public function setLastName(string $last_name): void { $this->last_name = $last_name; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }
}