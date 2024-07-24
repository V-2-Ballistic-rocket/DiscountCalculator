<?php

namespace App\Domain;

use App\Domain\TicketFactory;

class TravelManager
{
    public function __construct(
        private TicketFactory $factory,
        private DiscountCalculator $discountCalculator
    )
    {}
    public function getNewPrice(PurchaseParametersDto $parametersDto){
       
        $ticket = $this->factory->getNewTicketFromPurchaseParametersDto($parametersDto);
        
        $kidDiscount = $this->discountCalculator->calculateKidDiscount($ticket);

        $ticket = $this->factory->getNewTicketFromOldTicketAndNewPrice($ticket, $ticket->price - $kidDiscount);

        $earlyBookingDiscount = $this->discountCalculator->earlyBookingDiscountCalculate($ticket);

        return $ticket->price - $earlyBookingDiscount;
    }
    
}