<?php

namespace spec\Moult\Delivery;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Psr7\ServerRequest as Request;
use GuzzleHttp\Psr7\Response;
use Moult\Delivery\Redirect;

class ControllerSpec extends ObjectBehavior
{
    /**
     * @param Moult\Delivery\Loader $loader
     * @param Moult\Delivery\Renderer $renderer
     */
    function let($loader, $renderer)
    {
        $request = (new Request('POST', 'controller'))
            ->withQueryParams(['a' => 'b'])
            ->withParsedBody(['c' => 'd']);

        $this->beConstructedWith(
            $request, new Response,
            $loader, $renderer
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Moult\Delivery\Controller');
    }

    /**
     * @param Moult\Delivery\Usecase $usecase
     */
    function it_handles_a_usecase($usecase, $loader, $renderer)
    {
        $usecase->execute()->shouldBeCalled()->willReturn((object) ['foo' => 'bar']);
        $this->setupLoader($loader, $usecase);
        $view = new \Moult\Delivery\View;
        $view->foo = 'bar';
        $renderer->render('template', $view)->shouldBeCalled()->willReturn('ui');
        $this->execute();
        $this->response->getStatusCode()->shouldBe(200);
        $this->response->getBody()->getContents()->shouldBe('ui');
    }

    /**
     * @param Moult\Delivery\Usecase $usecase
     */
    function it_handles_usecase_exceptions_by_redirecting($usecase, $loader)
    {
        $usecase->execute()->shouldBeCalled()->willThrow('Exception');
        $this->setupLoader($loader, $usecase);
        $this->execute();
        $this->response->getStatusCode()->shouldBe(303);
        $this->response->getHeaderLine('Location')->shouldBe('homepage');
    }

    function setupLoader($loader, $usecase)
    {
        $data = new \Moult\Delivery\Data;
        $data->a = 'b';
        $data->c = 'd';
        $loader->load('User\View', [
            'Usecase\User\View' => [
                'Data\Data' => $data
            ]
        ])->shouldBeCalled()
        ->willReturn($usecase);
        return $loader;
    }
}
