<?php

namespace App\Controller\Api;

use App\DTO\Booking\BookingRequestDto;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    #[Route('/api/bookings', name: 'api_booking_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] BookingRequestDto $dto,
        BookingService $bookingService
    ): JsonResponse {
        try {
            // $this->getUser() obtiene el usuario del Token JWT automáticamente
            $user = $this->getUser(); 
            
            $booking = $bookingService->createBooking($user, $dto);

            return $this->json([
                'message' => 'Reserva confirmada',
                'totalPrice' => $booking->getTotalPrice()
            ], 201);

        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}