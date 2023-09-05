<?php

namespace App\Services;

class BookingService
{
    public function getPrices(): array
    {
        return [
            [
                'hotel_id' => 1,
                'price' => 1000,
            ],
            [
                'hotel_id' => 2,
                'price' => 2000,
            ],
            [
                'hotel_id' => 3,
                'price' => 5000,
            ],
            [
                'hotel_id' => 4,
                'price' => 4000,
            ],
        ];
    }
}
