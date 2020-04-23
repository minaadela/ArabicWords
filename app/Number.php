<?php

namespace App;

/**
 * Class Number
 */
class Number
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $stack = [];

    /**
     * @var bool
     */
    private $isNegative = false;

    const AND = 'و';

    /**
     * Number constructor.
     */
    public function __construct()
    {
        $this->data = include __DIR__.'/ArabicNumbers.php';
    }

    /**
     * Format numbers to arabic words.
     *
     * @param int $number
     * @return string
     * @throws \Exception
     */
    public function format(int $number)
    {
        try {
            return $this->handleFormat($number);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Handle format numbers process.
     *
     * @param int $number
     * @return string
     * @throws \Exception
     */
    private function handleFormat(int $number)
    {
        $this->checkNumberLength($number);

        //Handle zero
        if ($number === 0) {
            return $this->handleZero($number);
        }

        //handle negative number
        if ($number < 0) {
            $number = $this->handleNegativeNumber($number);
        }

        //Split the number to three digits
        $numbers = $this->splitNumberToThreeDigits($number);
        // Reverse numbers array with the same keys to differentiate
        // between categories (Hundreds, Thousands, Millions).
        $numbers = array_reverse($numbers, true);

        foreach ($numbers as $index => $number) {
            // Convert the number to int to remove the leading zeros.
            $number = (int) $number;

            //Skip zeros
            if ($number == 0) {
                continue;
            }

            //Convert the default numbers which is smaller than 100 to words.
            $text = $this->formatDefaultNumbers($number);

            if (empty($text)) {
                continue;
            }

            if ($index != 0) {
                if ($number > 10) {
                    $text = $text.' '.$this->data['largeNumbers'][$index][1];
                } elseif ($number > 2) {
                    $text = $text.' '.$this->data['largeNumbers'][$index][3];
                } else {
                    $text = $this->data['largeNumbers'][$index][$number];
                }
            }

            $this->setStack($text);
        }

        return $this->output();
    }

    /**
     * Return output text
     *
     * @return string
     */
    private function output()
    {
        $output = '';
        if ($this->isNegative) {
            $output = $this->data['operators']['negative'].' ';
        }

        $output .= implode(' '.self:: AND.' ', $this->stack);

        return $output;
    }

    /**
     * handle single zero.
     *
     * @param $number
     * @return string
     */
    private function handleZero($number)
    {
        $text = $this->data['default'][$number];
        $this->setStack($text);

        return implode(' '.self:: AND.' ', $this->stack);
    }

    /**
     * Convert the minus number into a positive number.
     *
     * @param $number
     * @return int
     */
    private function handleNegativeNumber($number)
    {
        $this->setIsNegative(true);

        return abs($number);
    }

    /**
     * Set stack
     *
     * @param $value
     */
    private function setStack($value)
    {
        array_push($this->stack, $value);
    }

    private function setIsNegative($value)
    {
        $this->isNegative = $value;
    }

    /**
     * Format the default numbers
     *
     * @param $number
     * @return string
     */
    private function formatDefaultNumbers($number)
    {

        $arabicNumbers = [];
        if ($number > 99) {
            $hundreds = $this->roundDown($number, 100);
            array_push($arabicNumbers, $this->data['default'][$hundreds]);

            $number = $number % 100;
        }

        if ($number != 0) {
            if ($number <= 20) {
                array_push($arabicNumbers, $this->data['default'][$number]);
            } else {
                $ones = $number % 10;
                if ($ones > 0) {
                    array_push($arabicNumbers, $this->data['default'][$ones]);
                }

                $tens = $this->roundDown($number, 10);
                array_push($arabicNumbers, $this->data['default'][$tens]);
            }
        }

        return implode(' '.self:: AND.' ', $arabicNumbers);
    }

    /**
     * round down the number.
     *
     * @param $number
     * @param $base
     * @return float|int
     */
    private function roundDown($number, $base)
    {
        return floor($number / $base) * $base;
    }

    /**
     * split the number to three digits.
     *
     * @param $number
     * @return array
     */
    private function splitNumberToThreeDigits($number)
    {
        return array_map("strrev", (str_split(strrev($number), 3)));
    }

    /**
     * Check number length.
     *
     * @param $number
     * @throws \Exception
     */
    private function checkNumberLength($number)
    {
        if (strlen($number) > 18) {
            throw new Exception('Error. The max length is 18.');
        }
    }
}