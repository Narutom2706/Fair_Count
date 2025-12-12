<?php

namespace App\Model;

class Expense
{
    private ?int $id = null;
    private string $title;
    private int $amount;
    private string $date;
    private int $user_id;
    private int $category_id;

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAmount(): int { return $this->amount; }
    public function getDate(): string { return $this->date; }
    public function getUserId(): int { return $this->user_id; }
    public function getCategoryId(): int { return $this->category_id; }

    public function setId(int $id): void { $this->id = $id; }
    public function setTitle(string $title): void { $this->title = $title; }
    public function setAmount(int $amount): void { $this->amount = $amount; }
    public function setDate(string $date): void { $this->date = $date; }
    public function setUserId(int $user_id): void { $this->user_id = $user_id; }
    public function setCategoryId(int $category_id): void { $this->category_id = $category_id; }
}