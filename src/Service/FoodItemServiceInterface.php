<?php

namespace App\Service;

interface FoodItemServiceInterface
{
    public function list(?string $name, ?int $minWeight, ?int $maxWeight): array;
    public function search(int $id): object|null;
    public function add(string $name, int $grams): void;
}
