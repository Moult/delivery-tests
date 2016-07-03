<?php

namespace spec\Moult\Delivery;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Moult\Delivery\Data');
    }

    function it_has_data()
    {
        $this->a->shouldBe(NULL);
        $this->c->shouldBe(NULL);
    }
}
