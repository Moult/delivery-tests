<?php

namespace Moult\Delivery;

class View
{
    public $foo;

    public function foo()
    {
        return 'foo'.$this->foo;
    }
}
