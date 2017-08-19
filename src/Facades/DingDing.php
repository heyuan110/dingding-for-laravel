<?php

namespace PatPat\DingDing\Facades;

use Illuminate\Support\Facades\Facade;

class DingDing extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dingding';
    }
}
