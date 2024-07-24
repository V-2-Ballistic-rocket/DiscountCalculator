<?php

namespace App\Domain;

use App\Domain\Ticket;

class DiscountCalculator
{

    public function calculateKidDiscount(Ticket $ticket) : int
    {
        $interval = $ticket->birthDate->diff($ticket->tripDate);
        $years = $interval->y;
        
        $discount = 0;
        if($years >= 18){
            return $discount;
        }
        if($years >= 12){
            $discount = $ticket->price * 0.1;
            return $discount;
        }
        if($years >= 6){
            $discount = $ticket->price * 0.3;
            return $discount > 4500 ? 4500 : $discount;
        }
        if($years >= 3){
            $discount = $ticket->price * 0.8;
            return $discount;
        }
        return $discount;
    }

    public function earlyBookingDiscountCalculate(Ticket $ticket) : int
    {
        $nowYear = intval($ticket->purchaseDate->format('Y'));
        
        $discount = 0;

        //что путешествие пройдет в промежутке с марта до сентября след года включительно
        if (new \DateTime($nowYear + 1 . '-03-01') <= $ticket->tripDate && $ticket->tripDate < new \DateTime($nowYear + 1 . '-10-01'))
        {
            if($ticket->purchaseDate < new \DateTime($nowYear . '-12-01')){ //что покупка в ноябре или ранее
                $discount = $ticket->price * 0.07;
                return $discount > 1500 ? 1500 : $discount;
            }
            if($ticket->purchaseDate < new \DateTime($nowYear + 1 . '-01-01')){ //что покупка в декабре или ранее
                $discount = $ticket->price * 0.05;
                return $discount > 1500 ? 1500 : $discount;
            }
        }
        //что путешествие пройдет в промежутке с марта до сентября этого года включительно, но покупка будет до февраля
        if (new \DateTime($nowYear . '-03-01') <= $ticket->tripDate && $ticket->tripDate < new \DateTime($nowYear . '-10-01'))
        {
            if($ticket->purchaseDate < new \DateTime($nowYear . '-02-01')){ //что покупка в январе или ранее
                $discount = $ticket->price * 0.03;
                return $discount > 1500 ? 1500 : $discount;
            }
        }

        //что путешествие пройдет позже чем с 15 января след года включительно
        if ($ticket->tripDate > new \DateTime($nowYear + 1 . '-01-14')){
            if($ticket->purchaseDate < new \DateTime($nowYear . '-09-01')){ //что покупка в августе или ранее
                $discount = $ticket->price * 0.07;
                return $discount > 1500 ? 1500 : $discount;
            }
            if($ticket->purchaseDate < new \DateTime($nowYear . '-10-01')){ //что покупка в сентябре или ранее
                $discount = $ticket->price * 0.05;
                return $discount > 1500 ? 1500 : $discount;
            }
            if($ticket->purchaseDate < new \DateTime($nowYear . '-11-01')){ //что покупка в октябре или ранее
                $discount = $ticket->price * 0.03;
                return $discount > 1500 ? 1500 : $discount;
            }
        }

        //что путешествие пройдет в промежутке с октября этого года до 15 января след года не включительно
        if (new \DateTime($nowYear . '-10-01') <= $ticket->tripDate && $ticket->tripDate < new \DateTime($nowYear + 1 . '-01-15')){
            if($ticket->purchaseDate < new \DateTime($nowYear . '-04-01')){ //что покупка в марте или ранее
                $discount = $ticket->price * 0.07;
                return $discount > 1500 ? 1500 : $discount;
            }
            if($ticket->purchaseDate < new \DateTime($nowYear . '-05-01')){ //что покупка в апреле или ранее
                $discount = $ticket->price * 0.05;
                return $discount > 1500 ? 1500 : $discount;
            }
            if($ticket->purchaseDate < new \DateTime($nowYear . '-06-01')){ //что покупка в мае или ранее
                $discount = $ticket->price * 0.03; 
                return $discount > 1500 ? 1500 : $discount;
            }
        }

        return $discount;
    }
}