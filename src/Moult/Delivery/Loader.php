<?php

namespace Moult\Delivery;

interface Loader
{
    public function load($usecase, $dependencies = []);
}
