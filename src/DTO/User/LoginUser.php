<?php

namespace App\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO para login de usuario
 */

class LoginUser {
    #[Assert\NotBlank(message: 'Debe indicar el correo.')]
    #[Assert\Email(message: 'El email es inválido.')]
    public readonly string $email;

    #[Assert\NotBlank(message: 'Debe indicar la contraseña.')]
    #[Assert\Length(min: 8)]
    public readonly string $password;
}