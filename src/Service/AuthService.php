<?php

namespace App\Service;

use App\DTO\User\LoginUser;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager
    ) {}

    public function authenticate(LoginUser $dto): string
    {
        // 1. Usamos el Repositorio para buscar al usuario
        $user = $this->userRepository->findOneBy(['email' => $dto->email]);

        if (!$user || !$user->getIsActive()) {
            throw new BadCredentialsException('Usuario no encontrado o inactivo.');
        }

        // 2. Usamos el Hasher para validar la contraseña
        $isPasswordValid = $this->passwordHasher->isPasswordValid($user, $dto->password);

        if (!$isPasswordValid) {
            throw new BadCredentialsException('Credenciales inválidas.');
        }

        // 3. Generamos el Token JWT
        return $this->jwtManager->create($user);
    }
}