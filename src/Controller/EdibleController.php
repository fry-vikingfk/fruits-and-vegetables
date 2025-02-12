<?php

namespace App\Controller;

use App\Entity\Edible;
use App\Traits\EdibleTrait;
use App\Service\EdibleService;
use App\Traits\RequestValidatorTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/edible')]
final class EdibleController extends AbstractController
{
    use EdibleTrait;
    use RequestValidatorTrait;

    public function __construct(
        private readonly EdibleService $edibleService,
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer
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
                maxWeight: $request->query->get('maxWeight') ?? null,
            );

            $normalizedEdibles = $this->serializer->serialize($edibles, 'json', [
                'unit' => $request->query->get('unit'), 
            ]);

            $response = ['edibles' =>  json_decode($normalizedEdibles, true)];

        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json($response, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_edible_show', methods: ['GET'])]
    public function search(Edible $edible, Request $request): JsonResponse
    {
        if (!$edible) {
            return $this->json([
                'message' => "Edible not found"], 
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        try {

            $normalizedEdibles = $this->serializer->serialize($edible, 'json', [
                'unit' => $request->query->get('unit'), 
            ]);

            $response = ['edible' =>  json_decode($normalizedEdibles, true)];
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json($response, JsonResponse::HTTP_OK);
    }

    #[Route('', name: 'app_edible_add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        try {
            $edible = $this->serializer->deserialize(
                $request->getContent(),
                $this->getEdibleClassByType($request->toArray()['type']),
                'json'
            );

            if($errorMessage = $this->validate($edible))
            {
                return $this->json([
                    'message' => 'Validation error',
                    'errors' => $errorMessage
                ], JsonResponse::HTTP_BAD_REQUEST);
            }

            $this->edibleService->add($edible);
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json(['edible' => $edible], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_edible_delete', methods: ['DELETE'])]
    public function delete(Edible $edible): JsonResponse
    {
        if (!$edible) {
            return $this->json(['message' => "Edible not found"], JsonResponse::HTTP_NOT_FOUND);
        }

        $id = $edible->getId();

        try {
            $this->edibleService->remove($edible);
            
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());  
        }

        return $this->json(['message' => "edible with id $id deleted"], JsonResponse::HTTP_OK);
    }
}
