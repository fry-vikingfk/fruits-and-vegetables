<?php

namespace App\Service;

use App\Repository\EdibleRepository;

class EdibleService
{
    public function __construct(
        private readonly EdibleRepository $edibleRepository
    )
    {
    }

    public function list(): array
    {
        return $this->edibleRepository->findAll();
    }

    public function search(int $id): ?object
    {
        return $this->edibleRepository->find($id);
    }
}
