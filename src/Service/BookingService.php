<?php

namespace App\Service;

use App\DTO\Booking\BookingRequestDto;
use App\Entity\Booking;
use App\Entity\User;
use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookingService {
    public function __construct(
        private EntityManagerInterface $em,
        private ExperienceRepository $experienceRepo
    ) {}

    public function createBooking(User $user, BookingRequestDto $dto): Booking
    {
        $experience = $this->experienceRepo->find($dto->experienceId);
        
        if (!$experience) {
            throw new \Exception("La experiencia no existe.");
        }

        // VALIDACIÓN DE NEGOCIO: ¿Hay plazas?
        if ($dto->participants > $experience->getMaxPlaces()) {
            throw new \Exception("No hay plazas suficientes. Máximo disponible: " . $experience->getMaxPlaces());
        }

        $booking = new Booking();
        $booking->setUser($user);
        $booking->setExperience($experience);
        $booking->setQuantity($dto->participants);
        
        // Cálculo de precio total en el servidor (Seguridad)
        $total = (float)$experience->getPrice() * $dto->participants;
        $booking->setTotalPrice((string)$total);
        $booking->setStatus('confirmed');

        // Actualizamos las plazas disponibles de la experiencia
        $experience->setMaxPlaces($experience->getMaxPlaces() - $dto->participants);

        $this->em->persist($booking);
        $this->em->flush();

        return $booking;
    }
}