<?php

namespace spec\Moult\Delivery;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ViewSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Moult\Delivery\View');
    }

    function it_processes_foo()
    {
        $this->foo = 'bar';
        $this->foo()->shouldReturn('foobar');
    }
}
