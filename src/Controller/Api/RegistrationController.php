<?php

namespace App\Controller\Api;

use App\Dto\User\RegistrationUser;
use App\Service\UserRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController {
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] RegistrationUser $registrationUser,
        UserRegistrationService $service
    ): JsonResponse {
        try {
            $user = $service->register($registrationUser);

            return $this->json([
                'error' => 'Usuario creado con éxito.',
                'user' => $user->getUserIdentifier()
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return $this->json([
                'error' => 'No se pudo crear el usuario: ' . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}