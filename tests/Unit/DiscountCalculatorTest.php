<?php
namespace App\tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Domain\Ticket;
use App\Domain\DiscountCalculator;

class DiscountCalculatorTest extends TestCase
{
    public function testKid14yoDiscount() : void
    {
        $ticket = new Ticket(
            1000,
            new \DateTime('2010-01-01'),
            new \DateTime('2024-01-02'),
            new \DateTime('2024-01-01'),
        );
        
        $calculator = new DiscountCalculator();
        $discount = $calculator->calculateKidDiscount($ticket);
        
        $this->assertEquals(100, $discount);
    }

    public function testKid11yoDiscount() : void
    {
        $ticket = new Ticket(
            1000,
            new \DateTime('2011-01-01'),
            new \DateTime('2022-01-02'),
            new \DateTime('2022-01-01'),
        );

        $calculator = new DiscountCalculator();
        $discount = $calculator->calculateKidDiscount($ticket);

        $this->assertEquals(300, $discount);
    }

    public function testKid11yoDiscountMoreThen4500() : void
    {
        $ticket = new Ticket(
            100000,
            new \DateTime('2011-01-01'),
            new \DateTime('2022-01-02'),
            new \DateTime('2022-01-01'),
        );

        $calculator = new DiscountCalculator();
        $discount = $calculator->calculateKidDiscount($ticket);

        $this->assertEquals(4500, $discount);
    }

    public function testKid5yoDiscount() : void
    {
        $ticket = new Ticket(
            1000,
            new \DateTime('2018-01-01'),
            new \DateTime('2022-01-02'),
            new \DateTime('2022-01-01'),
        );

        $calculator = new DiscountCalculator();
        $discount = $calculator->calculateKidDiscount($ticket);

        $this->assertEquals(800, $discount);
    }



    /**
     * @dataProvider earlyBookingDiscount7CalculateProvider
     */
    public function testEarlyBookingDiscount7Calculate(Ticket $ticket) : void
    {
        //когда скидка 7%, но не более 1500
        

        $calculator = new DiscountCalculator();
        $discount = $calculator->earlyBookingDiscountCalculate($ticket);

        $this->assertEquals($ticket->price * 0.07, $discount);
    }

    public function earlyBookingDiscount7CalculateProvider(): array
    {
        return [
            'когда отъезд 1.05.27, а покупка 30.11.26' => [new Ticket(
                1000,
                new \DateTime('2000-01-01'),
                new \DateTime('2027-05-01'),
                new \DateTime('2026-11-30'),
            )],
            'когда отъезд 15.01.27, а покупка 31.08.26' => [new Ticket(
                1000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-01-15'),
                new \DateTime('2026-08-31'),
            )],
            'когда отъезд 5.10.27, а покупка 30.03.26' => [new Ticket(
                1000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-10-05'),
                new \DateTime('2027-03-30'),
            )]
        ];
    }


    /**
     * @dataProvider earlyBookingDiscount5CalculateProvider
     */
    public function testEarlyBookingDiscount5Calculate(Ticket $ticket) : void
    {
        //когда скидка 5%, но не более 1500
        

        $calculator = new DiscountCalculator();
        $discount = $calculator->earlyBookingDiscountCalculate($ticket);

        $this->assertEquals($ticket->price * 0.05, $discount);
    }

    public function earlyBookingDiscount5CalculateProvider(): array
    {
        return [
            'когда отъезд 1.05.27, а покупка 30.12.26' => [new Ticket(
                1000,
                new \DateTime('2000-01-01'),
                new \DateTime('2027-05-01'),
                new \DateTime('2026-12-30'),
            )],
            'когда отъезд 15.01.27, а покупка 30.09.26' => [new Ticket(
                1000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-01-15'),
                new \DateTime('2026-09-30'),
            )],
            'когда отъезд 5.10.27, а покупка 30.04.26' => [new Ticket(
                1000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-10-05'),
                new \DateTime('2027-04-30'),
            )]
        ];
    }

    /**
     * @dataProvider earlyBookingDiscount3CalculateProvider
     */
    public function testEarlyBookingDiscount3Calculate(Ticket $ticket) : void
    {
        //когда скидка 3%, но не более 1500

        $calculator = new DiscountCalculator();
        $discount = $calculator->earlyBookingDiscountCalculate($ticket);

        $this->assertEquals($ticket->price * 0.03, $discount);
    }

    public function earlyBookingDiscount3CalculateProvider(): array
    {
        return [
            'когда отъезд 1.05.27, а покупка 31.01.27' => [new Ticket(
                1000,
                new \DateTime('2000-01-01'),
                new \DateTime('2027-05-01'),
                new \DateTime('2027-01-31'),
            )],
            'когда отъезд 15.01.27, а покупка 30.10.26' => [new Ticket(
                1000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-01-15'),
                new \DateTime('2026-10-30'),
            )],
            'когда отъезд 5.10.27, а покупка 30.05.26' => [new Ticket(
                1000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-10-05'),
                new \DateTime('2027-05-30'),
            )]
        ];
    }

    /**
     * @dataProvider whenDiscountEarlyBookingIsMoreThan1500Provider
     */
    public function testWhenDiscountEarlyBookingIsMoreThan1500(Ticket $ticket) : void
    {
        //когда скидка более 1500

        $calculator = new DiscountCalculator();
        $discount = $calculator->earlyBookingDiscountCalculate($ticket);

        $this->assertEquals(1500, $discount);
    }

    public function whenDiscountEarlyBookingIsMoreThan1500Provider(): array
    {
        return [
            'когда отъезд 15.01.27, а покупка 30.09.26' => [new Ticket(
                30000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-01-15'),
                new \DateTime('2026-09-30'),
            )],
            'когда отъезд 15.01.27, а покупка 30.10.26' => [new Ticket(
                50000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-01-15'),
                new \DateTime('2026-10-30'),
            )],
            'когда отъезд 5.10.27, а покупка 30.03.26' => [new Ticket(
                22000,
                new \DateTime('2010-01-01'),
                new \DateTime('2027-10-05'),
                new \DateTime('2027-03-30'),
            )]
        ];
    }
}
