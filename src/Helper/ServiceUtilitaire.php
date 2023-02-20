<?php

namespace App\Helper;

class ServiceUtilitaire
{
    public function noDoublon($lesSorties){
        $vretour=[];
        foreach ($lesSorties as $sortie){
            if(!in_array($sortie,$vretour)){
                array_push($vretour,$sortie);
            }
        }
        return $vretour;
    }
}