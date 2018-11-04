<?php

namespace Flaravel;

use Illuminate\Support\Manager;
use InvalidArgumentException;

class Fsms extends Manager
{
    private $driver;

    public function driver($driver = null)
    {
        $this->driver = $driver ?: $this->getDefaultDriver();
        if (is_null($this->driver)) {
            throw new InvalidArgumentException(sprintf(
                'Unable to resolve NULL driver for [%s].', static::class
            ));
        }
        return $this->createSmsDriver();
    }

    public function createSmsDriver()
    {
        return $this->bindComponent(new FalismsSend());
    }

    protected function bindComponent($driver)
    {
        return new FaliSms($driver,$this->driver);
    }

    public function getDefaultDriver()
    {
        return $this->app['config']['alisms']['driver'];
    }
}
