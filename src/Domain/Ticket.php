<?php

namespace App\Domain;

readonly class Ticket
{
    public function __construct(
        public int $price,
        public \DateTime $birthDate,
        public \DateTime $tripDate,
        public \DateTime $purchaseDate
    )
    {
    }
}