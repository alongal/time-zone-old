<?php

namespace Alongal\TimeZone;

use DateTimeZone;
use Illuminate\Support\Carbon;

class TimeZone
{
    private function __construct()
    {
    }

    public static function createFromCoordinates($latitude, $longitude)
    {

    }

    public function getFromCoordinates($latitude, $longitude)
    {
        $timezone = $this->get_nearest_timezone($latitude, $longitude);

        return Carbon::now($timezone);
    }

    /* Code was adapted from
    https://stackoverflow.com/questions/3126878/get-php-timezone-name-from-latitude-and-longitude
    */
    function get_nearest_timezone($cur_lat, $cur_long, $country_code = '')
    {
        $timezone_ids = ($country_code) ?
            DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code) :
            DateTimeZone::listIdentifiers();

        if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

            $time_zone = '';
            $tz_distance = 0;

            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else {

                foreach ($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat = $location['latitude'];
                    $tz_long = $location['longitude'];

                    $theta = $cur_long - $tz_long;
                    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                        + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                    $distance = acos($distance);
                    $distance = abs(rad2deg($distance));

                    if ( ! $time_zone || $tz_distance > $distance) {
                        $time_zone = $timezone_id;
                        $tz_distance = $distance;
                    }
                }
            }

            return $time_zone;
        }
        return 'UTC';
    }
}
