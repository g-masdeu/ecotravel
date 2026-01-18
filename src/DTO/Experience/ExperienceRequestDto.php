<?php

namespace App\DTO\Experience;

use Symfony\Component\Validator\Constraints as Assert;

class ExperienceRequestDto {
    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    public string $title;

    #[Assert\NotBlank]
    public string $description;

    #[Assert\NotBlank]
    #[Assert\Positive]
    public string $price; 

    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $maxPlaces;
}