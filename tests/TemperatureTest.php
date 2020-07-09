<?php

namespace App\Tests;

use App\Service\Temperature;
use PHPUnit\Framework\TestCase;

class TemperatureTest extends TestCase
{
    private $temperature;

    public function __construct()
    {
        parent::__construct();
        $this->temperature = new Temperature();
    }

    public function testTemperatureIsNumeric()
    {
        for ($i = 0; $i < 100; $i++) {
            $degrees = $this->temperature->getTemperature();

            $this->assertIsNumeric($degrees);
        }
    }

    public function testTemperatureIsBetweenLimits()
    {
        for ($i = 0; $i < 100; $i++) {
            $degrees = $this->temperature->getTemperature();

            $this->assertGreaterThanOrEqual(15, $degrees);
            $this->assertLessThanOrEqual(25, $degrees);
        }
    }
}