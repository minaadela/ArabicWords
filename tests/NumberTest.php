<?php

namespace Tests;

use App\Number;

class NumberTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        foreach (range(1, 10000) as $loop) {
            $randomNumber = rand();
            $number = new Number();

            $numberFormat = new \NumberFormatter("ar", \NumberFormatter::SPELLOUT);

            //$this->assertSame('واحد', $number->format(1));
            $this->assertSame($numberFormat->format($randomNumber), $number->format($randomNumber));
        }
    }
}
