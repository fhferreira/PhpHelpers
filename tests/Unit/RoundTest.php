<?php

namespace Tests\Unit;

use Helpers\Round;
use Tests\TestCase;

class RoundTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAmounts()
    {
        $amounts = array(
            [12.6529, 12.65],
            [12.86512, 12.87],
            [12.744623, 12.74],
            [12.8752, 12.88],
            [12.8150, 12.82],
            [12.8050, 12.80],
            [12.5, 12.50],
            [12.3, 12.30],
            [12.33, 12.33],
            [12, 12],
        );

        foreach ($amounts as $index => $amountInfo) {
            $rounded = Round::ABNT($amountInfo[0]);
            echo 'Number: ', $amountInfo[0], ' - Expected: ', $amountInfo[1], ' - Rounded: ', $rounded, PHP_EOL;
            $this->assertEquals($rounded, $amountInfo[1]);
        }

    }
}
