<?php

namespace Alongal\Tests;

use Alongal\TimeZone\TimeZone;
use Orchestra\Testbench\TestCase;

class TimeZoneTest extends TestCase
{
    /** @test */
    public function it_can_return_the_time_zone_of_a_given_coordinates()
    {
        $melbourneCoordinates = [
            'latitude' => -38.1081,
            'longitude' => 145.306
        ];

        $this->assertEquals('Australia/Melbourne',
            TimeZone::createFromCoordinates(
                $melbourneCoordinates['latitude'],
                $melbourneCoordinates['longitude']
            )->getTimezone()
        );
    }
}
