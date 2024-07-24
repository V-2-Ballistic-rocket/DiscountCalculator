<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\TravelManager;
use App\Domain\PurchaseParametersDto;

class DiscountController extends AbstractController
{
    public function __construct(
        private TravelManager $travelManager
    )
    {}

    #[Route('/', methods: ['GET'])]
    public function getPriceWhithDiscount(Request $request) : Response
    {
        $currentDate = date('d-m-Y');
        // dd($request->query->get('birth_date'));
        echo $this->travelManager->getNewPrice(new PurchaseParametersDto(
            intval($request->query->get('price')),
            $request->query->get('birth_date'),
            $request->query->get('trip_date', (string)$currentDate),
            $request->query->get('purchase_date', (string)$currentDate)
        ));
        
        return new Response("");
    }
}