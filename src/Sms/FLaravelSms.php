<?php

namespace Flaravel;

use Illuminate\Support\Facades\Facade;
/**
 * @method static bool|string scode(string $mobile,string $code = '')
 * @method static bool|string notice(string $mobile,string $driver,array $product)
 * @method static bool|string drivers(string $method,string $driver,string $mobile,array $product = [])  //driver 只有 notice code
 */

class FLaravelSms extends Facade
{
    protected static function getFacadeAccessor() {

        return 'alisms';
    }
}
