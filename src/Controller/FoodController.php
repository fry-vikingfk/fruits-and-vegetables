<?php

namespace App\Controller;

use App\Repository\FruitRepository;
use App\Service\FoodService;
use App\Service\FoodServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/food')]
final class FoodController extends AbstractController
{
    public function __construct(
        private readonly FoodServiceInterface $foodService,
        private readonly SerializerInterface $serializer
        )
    {
    }

    #[Route('', name: 'app_food', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        try {
            $response = $this->foodService->list(
                type: $request->query->get('type') ?? null,
                name: $request->query->get('name') ?? null,
                minWeight: $request->query->get('minWeight') ?? null,
                maxWeight: $request->query->get('maxWeight') ?? null
            );
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->json($response, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/{type}', name: 'app_food_search', methods: ['GET'])]
    public function search(string $type, int $id): JsonResponse
    {
        try {
            $response = $this->foodService->search(
                type: $type, 
                id: $id
            );
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $response, 
            JsonResponse::HTTP_OK);
    }
}
