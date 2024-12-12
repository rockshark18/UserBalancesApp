<?php

namespace App\Util;

class RealLagSimulation{
    public static function handle($minMs, $maxMs){
        usleep(rand($minMs,$maxMs)*1000); // real lag simulation
    }
}

