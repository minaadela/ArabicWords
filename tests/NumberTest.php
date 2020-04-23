<?php

namespace Tests;

use App\Number;

class NumberTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        foreach (range(0, 10000) as $loop) {
            $randomNumber = rand();
            $number = new Number();

            $numberFormat = new \NumberFormatter("ar", \NumberFormatter::SPELLOUT);

            $this->assertSame($numberFormat->format($randomNumber), $number->format($randomNumber));
        }
    }
}
