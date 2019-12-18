<?php

namespace Helpers;

/*
As regras de arredondamento, seguindo a Norma ABNT NBR 5891, aplicam-se aos algarismos decimais situados na posição seguinte ao número de algarismos decimais que se queira transformar, ou seja, se tivermos um número de 4, 5, 6, n algarismos decimais e quisermos arredondar para 2, aplicar-se-ão estas regras de arredondamento:

Se os algarismos decimais seguintes forem menores que 50, 500, 5000..., o anterior não se modifica.
Se os algarismos decimais seguintes forem maiores a 50, 500, 5000..., o anterior incrementa-se em uma unidade.
Se os algarismos decimais seguintes forem iguais a 50, 500, 5000..., verifica-se o anterior;se for par, o anterior não se modifica;se for impar, o anterior incrementa-se em uma unidade.
Exemplos	Editar
Arredondando a 2 algarismos decimais deveremos ter em atenção o terceiro e quarto decimal. Assim, conforme as regras anteriores:

O número 12,6529 seria arredondado para 12,65 (aqui fica 12.65, uma vez que 29 é inferior a 50, então não se modifica)
O número 12,86512 seria arredondado para 12,87 (aqui fica 12.87, uma vez que 512 é superior a 500, então incrementa-se uma unidade)
O número 12,744623 seria arredondado para 12,74 (aqui fica 12.74, uma vez que 4623 é inferior a 5000, então não se modifica)
O número 12,8752 seria arredondado para 12,88 (aqui fica 12.88, uma vez que 52 é superior a 50, então incrementa-se uma unidade)
O número 12,8150 seria arredondado para 12,82 (aqui fica 12.82, uma vez que os algarismos seguintes é igual a 50 e o anterior é impar,nesse caso 1, então incrementa-se uma unidade)
O número 12,8050 seria arredondado para 12,80 (aqui fica 12.80, uma vez que os algarismos seguintes é igual a 50 e o anterior é par,nesse caso 0,então o anterior não se modifica)
*/

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
