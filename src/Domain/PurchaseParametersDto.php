<?php
namespace App\Domain;

readonly class PurchaseParametersDto
{
    public function __construct(
        public int $price = 0,
        public string $birthDate = "",
        public ?string $tripDate = null,
        public ?string $purchaseDate = null
    )
    {

    }
}