<?php

namespace App\Model;

class Reimbursement
{
    private ?int $id = null;
    private int $amount;
    private string $date;
    private int $user_id_from;
    private int $user_id_to;

    public function getId(): ?int { return $this->id; }
    public function getAmount(): int { return $this->amount; }
    public function getDate(): string { return $this->date; }
    public function getUserIdFrom(): int { return $this->user_id_from; }
    public function getUserIdTo(): int { return $this->user_id_to; }

    public function setId(int $id): void { $this->id = $id; }
    public function setAmount(int $amount): void { $this->amount = $amount; }
    public function setDate(string $date): void { $this->date = $date; }
    public function setUserIdFrom(int $user_id_from): void { $this->user_id_from = $user_id_from; }
    public function setUserIdTo(int $user_id_to): void { $this->user_id_to = $user_id_to; }
}