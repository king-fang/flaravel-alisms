<?php

namespace Flaravel;

class FaliSms {

    private $aliSms;

    private $driver;

    public function __construct(AliSmsInterface $aliSms,$driver)
    {
        $this->aliSms = $aliSms;
        $this->driver = $driver;
    }

    public function scode(string $mobile,string $code = '')
    {
        return $this->aliSms->code($mobile,$this->driver,$code);
    }

    public function drivers(string $method,string $driver,string $mobile,array $product = [])
    {
        if(method_exists($this->aliSms,$method) && !empty($driver)){
            return $this->aliSms->drivers($method,$mobile,$driver,$product);
        }
        throw  new \InvalidArgumentException('Driving parameter exception.');
    }

    public function notice(string $mobile,string $driver,array $product){
        return $this->aliSms->notice($mobile,$driver,$product);
    }
}
