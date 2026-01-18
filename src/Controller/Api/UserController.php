<?php

namespace App\Controller\Api;

use App\DTO\User\RegistrationUser;
use App\DTO\User\LoginUser; 
use App\Service\UserRegistrationService;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController 
{
    /**
     * Endpoint para la autenticación de usuarios.
     * 
     * @param LoginUser $dto DTO con email y password validado automáticamente.
     * @param AuthService $authService Servicio que gestiona la lógica de JWT.
     */
    #[Route('/api/login', name: 'api_login', methods: ['POST'])] // Siempre POST para login
    public function login(
        #[MapRequestPayload] LoginUser $dto, // Usamos el DTO correcto, no el controlador
        AuthService $authService
    ): JsonResponse {
        try {
            $token = $authService->authenticate($dto);

            return $this->json([
                'token' => $token,
                'message' => 'Login con éxito.' 
            ]);

        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Endpoint para el registro de nuevos usuarios.
     * 
     * @param RegistrationUser $registrationUser DTO con los datos del nuevo usuario.
     * @param UserRegistrationService $service Servicio de persistencia y hasheo.
     */
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] RegistrationUser $registrationUser,
        UserRegistrationService $service
    ): JsonResponse {
        try {
            $user = $service->Register($registrationUser);

            return $this->json([
                'message' => 'Usuario creado con éxito.', 
                'user' => $user->getUserIdentifier()
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return $this->json([
                'error' => 'No se pudo crear el usuario: ' . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}