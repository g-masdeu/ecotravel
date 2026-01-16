<?php

namespace App\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * DTO para capturar los datos de registro desde un JSON.
 */
class RegistrationUser {
    #[Assert\NotBlank(message: 'El nombre es obligatorio.')]
    #[Assert\Length(message: 2)]
    public string $firstName;

    #[Assert\NotBlank(message: 'El apellido es obligatorio.')]
    public string $lastName;

    #[Assert\NotBlank(message: 'El email es obligatorio.')]
    #[Assert\Email(message: 'Email inválido.')]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(\+34|0034|34)?[6789]\d{8}$/',
        message: 'Formato de teléfono no válido'
    )]
    public string $phone;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, message: 'La contraseña debe tener al menos 8 caracteres')]
    public string $password;
}