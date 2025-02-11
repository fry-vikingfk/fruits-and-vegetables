<?php

namespace App\Controller;

use App\Service\EdibleService;
use App\Traits\EdibleTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/edible')]
final class EdibleController extends AbstractController
{
    use EdibleTrait;

    public function __construct(
        private readonly EdibleService $edibleService,
    )
    {
    }

    #[Route('', name: 'app_edible_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        try {
            $edibles = $this->edibleService->list(
                type: $request->query->get('type') ?? null,
                name: ucfirst($request->query->get('name')) ?? null,
                minWeight: $request->query->get('minWeight') ?? null,
                maxWeight: $request->query->get('maxWeight') ?? null
            );
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json(['edibles' => $edibles], JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_edible_show', methods: ['GET'])]
    public function search(int $id): JsonResponse
    {
        try {
            $edible = $this->edibleService->search($id);
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json(['edible' => $edible], JsonResponse::HTTP_OK
        );
    }

    #[Route('', name: 'app_edible_add', methods: ['POST'])]
    public function add(Request $request, SerializerInterface $serializer): JsonResponse
    {
        try {
            $edible = $serializer->deserialize(
                $request->getContent(),
                $this->getEdibleClassByType($request->toArray()['type']),
                'json'
            );

            $this->edibleService->add($edible);
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json(['edible' => $edible], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'app_edible_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $edible = $this->edibleService->search($id);
            
            if (!$edible) {
                return $this->json(['message' => "Edible with id $id not found"], JsonResponse::HTTP_NOT_FOUND);
            }

            $this->edibleService->remove($edible);
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json(['message' => "dible with id $id deleted"], JsonResponse::HTTP_OK);
    }
}
