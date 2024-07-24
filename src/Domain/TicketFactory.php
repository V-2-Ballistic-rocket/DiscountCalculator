<?php

namespace App\Domain;

use App\Domain\Ticket;
use App\Domain\PurchaseParametersDto;
use App\Domain\DateFormatter;

class TicketFactory
{
    public function __construct(
        private DateFormatter $formatter
    )
    {}

    public function getNewTicketFromPurchaseParametersDto(PurchaseParametersDto $parameters) : Ticket
    {
        //тут могла быть (и должна быть) валидация 
        return new Ticket(
            $parameters->price,
            $this->formatter->formatDate($parameters->birthDate),
            $this->formatter->formatDate($parameters->tripDate),
            $this->formatter->formatDate($parameters->purchaseDate),
        );
    }

    public function getNewTicketFromOldTicketAndNewPrice(Ticket $ticket, int $newPrice) : Ticket
    {
        //тут могла быть (и должна быть) валидация 
        return new Ticket(
            $newPrice,
            $ticket->birthDate,
            $ticket->tripDate,
            $ticket->purchaseDate,
        );
    }
}