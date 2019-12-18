<?php

namespace Helpers;

class Round {

    public static function ABNT($number) {

        if (strpos($number, ',') !== false) {
            throw new \Exception('Não é permitido números formatados com virgulas.');
        }

        $numberArr = explode('.', "" . $number);

        $intPart = $numberArr[0];
        $decimalsNumbers = isset($numberArr[1]) ? $numberArr[1] : '00';

        $down = false;
        $up = false;

        if (strlen($decimalsNumbers) <= 2) {
            $decimalsNumbers = str_pad($decimalsNumbers, 2, '0', STR_PAD_RIGHT);
            return ((float) ($intPart . '.' . $decimalsNumbers));
        }

        $decimalsStr = substr($decimalsNumbers, 0, 2);
        $restStr = substr($decimalsNumbers, 2);

        if (strlen($restStr) == 1) {
            $restStr = $restStr . '0';
        }

        $strlenRest = strlen($restStr);
        $finalRest = str_pad(5,$strlenRest, '0', STR_PAD_RIGHT);

        if ($restStr < $finalRest) {
            $down = true;
            $up = false;
        } else if ($restStr > $finalRest) {
            $down = false;
            $up = true;
        } else if ($restStr == $finalRest) {
            if (((int)$decimalsStr[1])%2 == 1) {
                $down = false;
                $up = true;
            } else {
                $down = true;
                $up = false;
            }
        }

        $final = 0;

        if($down){
            $final = ((float) ($intPart . '.' . $decimalsStr));
        } else if($up){
            $decimals = $decimalsStr + 1;
            $sumInt = $decimals == 100 ? 1 : 0;
            if ($sumInt > 0) {
                $decimals = '00';
            }
            $final = ((float) (($intPart + $sumInt) . '.' . ($decimals)));
        }

        return $final;
    }

}
