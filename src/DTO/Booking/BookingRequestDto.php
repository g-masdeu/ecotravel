<?php

namespace App\DTO\Booking;

use Symfony\Component\Validator\Constraints as Assert;

class BookingRequestDto {
    #[Assert\NotBlank]
    public int $experienceId;

    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $participants;
}