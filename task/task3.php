<?php
$A1 = 1;
$An= 10000;
$n = 10000;

$Sn = $n * ($A1 + $An)/2;
$sum = 0;

for($i=$A1;$i<=$An;$i++)
{
    $flag = false;
    $numberInString = sprintf("%'05d\n", $i);
    for($j=0;$j<=strlen($numberInString)-3;$j++){
        $num3 = substr($numberInString,$j,3);
        if(find_asc($num3)){
            $flag = true;
            break;
        }
    }

    if($flag){
        //echo $numberInString.'<br>';
        $sum += $i;
    }
}

function find_asc($num){
    if(((int)substr($num,1,1) - 1) == (int)substr($num,0,1) and ((int)substr($num,2,1) - 1) == (int)substr($num,1,1)){
        return true;
    }
    return false;
}

echo "Сумма оставшихся чисел = ".($Sn - $sum);