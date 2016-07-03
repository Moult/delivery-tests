<?php

namespace Moult\Delivery;

interface Renderer
{
    public function render($template, $data);
}
