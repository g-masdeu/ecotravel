<?php

namespace App\Controller\Api;

use App\DTO\Experience\ExperienceRequestDto;
use App\Entity\Experience;
use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/experiences')]
class ExperienceController extends AbstractController
{
    /**
     * Listado público de experiencias.
     */
    #[Route('', name: 'api_experience_index', methods: ['GET'])]
    public function index(ExperienceRepository $repo): JsonResponse
    {
        // En una API real usaríamos un Serializer, pero para la prueba esto es rápido:
        $data = [];
        foreach ($repo->findAll() as $exp) {
            $data[] = [
                'id' => $exp->getId(),
                'title' => $exp->getTitle(),
                'price' => $exp->getPrice(),
                'maxPlaces' => $exp->getMaxPlaces()
            ];
        }
        return $this->json($data);
    }

    /**
     * Creación de experiencias (Solo Admins).
     */
    #[Route('', name: 'api_experience_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(
        #[MapRequestPayload] ExperienceRequestDto $dto,
        EntityManagerInterface $em
    ): JsonResponse {
        $exp = new Experience();
        $exp->setTitle($dto->title);
        $exp->setDescription($dto->description);
        $exp->setPrice($dto->price);
        $exp->setMaxPlaces($dto->maxPlaces);

        $em->persist($exp);
        $em->flush();

        return $this->json(['message' => 'Experiencia creada'], 201);
    }
}