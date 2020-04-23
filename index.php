<?php

//print_r($data);

require 'Number.php';

//$number = new Number();
//echo $number->format(10010).PHP_EOL;
//
//$f = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
//    echo $f->format(10010);
//die;
//foreach (range(10000, 100000) as $n) {

//$c = 100;
foreach (range(1, 10000) as $n) {
    $number = new Number();
    $myown = $number->format($n);

    $f = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
    $phpfun = $f->format($n);

    if ($myown != $phpfun) {
    echo $myown.PHP_EOL;
    echo $phpfun.PHP_EOL;
    }
}

//$f = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
//echo $f->format(101); // outpout : five hundred sixty-six thousand five hundred sixty

//echo convert(3100011);

function convert($number)
{
    $data = include __DIR__.'/ArabicNumbers.php';

    $numbers = splitNumberToThreeDigits($number);
    $arabicFinalNumbers = [];

    $numbers = array_reverse($numbers, true);
    //print_r($numbers);die;
    foreach ($numbers as $index => $number) {

        $number = (int) $number;

        $text = getDefaultNumbersToWords($number, $data);
        if (empty($text)) {
            continue;
        }

        switch ($index) {
            case 0:
                break;
            default:
                if ($number > 2) {
                    $text = $text.' '.$data['largeNumbers'][$index][3];
                } else {
                    $text = $data['largeNumbers'][$index][$number];
                }
                break;
        }

        array_push($arabicFinalNumbers, $text);
        //if ($number == 2) {
        //    //continue;
        //}

/////////////////////////
//        if ($i !== 0) {
//            if ($number === 1) {
//                $text = $data['largeNumbers'][$i][1];
//            } elseif ($number == 2) {
//                $text = $data['largeNumbers'][$i][$number];
//            } elseif ($number > 2 and $number < 11) {
//                $text .= ' '.$data['largeNumbers'][$i][3];
//            } else {
//                $text .= ' '.$this->complications[$i][4];
//            }
//        }

        //print $text;die;

        //array_push($items, $text);
        /////////////////////////////////////////
        //$tens = $this->calculateTensKey($number);
        //array_push($items, $this->getTensIndividualItem($tens));

        //if($i == 1){
        //    $numberx = floor($number / 100);
        //    array_push($arabicNumbers, $data['largeNumbers'][$i][$numberx]);
        //}

        //print_r($arabicNumbers);die;

        //print_r($arabicFinalNumbers);die;

        //break;
    }
    //print_r($arabicFinalNumbers);
    //die;

    return implode(" و", $arabicFinalNumbers);
}

function getDefaultNumbersToWords($number)
{
    if ($number == 0) {
        return;
    }
    $arabicNumbers = [];
    if ($number > 99) {
        $first = floor($number / 100) * 100;
        array_push($arabicNumbers, $data['default'][$first]);

        $number = $number % 100;
    }

    if ($number != 0) {
        if ($number <= 20) {
            array_push($arabicNumbers, $data['default'][$number]);
        } else {

            $numberx = $number % 10;
            //print $number.','.$numberx;die;
            if ($numberx === 2) {
                array_push($arabicNumbers, $data['default'][$numberx]);
            } elseif ($numberx > 0) {
                array_push($arabicNumbers, $data['default'][$numberx]);
            }
        }
    }

    return implode(" و", $arabicNumbers);
}

function splitNumberToThreeDigits($number)
{
    return array_map("strrev", (str_split(strrev($number), 3)));
}