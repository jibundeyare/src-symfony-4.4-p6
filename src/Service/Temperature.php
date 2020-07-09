<?php

namespace App\Service;

class Temperature
{
    public function getTemperature()
    {
        return random_int(15, 25);
    }
}