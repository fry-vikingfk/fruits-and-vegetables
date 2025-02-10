<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

interface FoodServiceInterface
{
    public function list(?string $type, ?string $name, ?int $minWeight, ?int $maxWeight): array;
    public function search(string $type, int $id): object|null;
    public function add(string $type, string $name, int $grams): void;
}
