<?php

abstract class Carrier {
    public $massa;
    abstract public function carrier_sena($massa);
}

class CarrierDhl extends Carrier {
    public function carrier_sena($massa) {
        return $massa*100;
    }
}

class CarrierPochtaRu extends Carrier {
    public function carrier_sena($massa) {
        if($massa < 10){
            return 100;
        }
        return 1000;
    }
}

// Добавление третьего перевозчика
class CarrierMaks extends Carrier {
    public function carrier_sena($massa) {
        return $massa*740;
    }
}

$massa = 109;
$Maks = new CarrierMaks();
$cost = $Maks->carrier_sena($massa);
echo($cost);