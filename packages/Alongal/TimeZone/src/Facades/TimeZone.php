<?php

namespace Alongal\TimeZone\Facades;

use Illuminate\Support\Facades\Facade;

class TimeZone extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'timezone';
    }
}
