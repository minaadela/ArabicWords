<?php

namespace Tests;

use App\Number;

class NumberTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        for ($i = 0; $i < 1000; $i++) {
            $randomNumber = rand();
            $number = new Number();

            $numberFormat = new \NumberFormatter("ar", \NumberFormatter::SPELLOUT);

            $this->assertSame($numberFormat->format($randomNumber), $number->format($randomNumber));
        }
    }
}
