<?php

namespace Alongal\TimeZone;

use DateTimeZone;
use Illuminate\Support\Carbon;

class TimeZone
{
    protected $latitude;
    protected $longitude;
    protected $timezone;
    protected $time;

    private function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timezone = $this->get_nearest_timezone($latitude, $longitude);
        $this->time = Carbon::now($this->timezone);

        return $this;
    }

    public static function createFromCoordinates($latitude, $longitude)
    {
        return new self($latitude, $longitude);
    }

    public function getTime($format = 'Y-m-d H:i:s')
    {
        return $this->time->format($format);
    }

    public function getTimezone()
    {
        return $this->timezone;
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
