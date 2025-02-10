<?php

namespace App\Controller;

use App\Service\EdibleService;
use Serializable;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/edible')]
final class EdibleController extends AbstractController
{
    public function __construct(
        private readonly EdibleService $edibleService,
    )
    {
    }

    #[Route('', name: 'app_edible_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        try {
            $edibles = $this->edibleService->list();
            
        } catch (\Exception $e) {
            return $this->json([
                    'message' => $e->getMessage(),
               ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );  
        }

        return $this->json([
                'edibles' => $edibles,
            ], JsonResponse::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'app_edible_show', methods: ['GET'])]
    public function search(int $id): JsonResponse
    {
        try {
            $edible = $this->edibleService->search($id);
            
        } catch (\Exception $e) {
            return $this->json([
                    'message' => $e->getMessage(),
               ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );  
        }

        return $this->json([
                'edible' => $edible,
            ], JsonResponse::HTTP_OK
        );
    }
}
