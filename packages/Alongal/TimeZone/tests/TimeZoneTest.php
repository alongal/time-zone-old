<?php

namespace Alongal\Tests;

use Alongal\TimeZone\TimeZone;
use Illuminate\Support\Carbon;
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

    /** @test */
    function it_can_return_the_time_at_given_coordinates_with_default_format_Y_m_d_H_i_s()
    {
        $melbourneCoordinates = [
            'latitude' => -38.1081,
            'longitude' => 145.306
        ];
        Carbon::setTestNow(Carbon::createFromTimeString('2000-01-01 10:00:00', 'Australia/Melbourne'));

        $this->assertEquals('2000-01-01 10:00:00',
            TimeZone::createFromCoordinates(
                $melbourneCoordinates['latitude'],
                $melbourneCoordinates['longitude']
            )->getTime()
        );
    }

    /** @test */
    function it_can_format_the_date_and_time_that_returned()
    {
        $melbourneCoordinates = [
            'latitude' => -38.1081,
            'longitude' => 145.306
        ];
        Carbon::setTestNow(Carbon::createFromTimeString('2000-01-01 10:00:00', 'Australia/Melbourne'));

        $this->assertEquals('Sat, 01 Jan 2000 10:00:00 +1100',
            TimeZone::createFromCoordinates(
                $melbourneCoordinates['latitude'],
                $melbourneCoordinates['longitude']
            )->getTime(DATE_RSS)
        );
    }
}
