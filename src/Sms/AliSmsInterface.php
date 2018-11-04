<?php

namespace Flaravel;


interface AliSmsInterface
{
    //验证码
    const SMS_CODE = 'code';

    //通知类
    const SMS_NOTICE = 'notice';

    public function code(string $mobile,string $driver,string $code = '');
    public function notice(string $mobile,string $driver,array $product);
    public function drivers(string $method,string $mobile,string $driver,array $product);
}
