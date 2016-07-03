<?php

namespace Moult\Delivery;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Psr7;
use Moult\Delivery\Redirect;

class Controller
{
    public $request;
    public $response;
    private $loader;
    private $renderer;

    public function __construct(Request $request, Response $response, Loader $loader, Renderer $renderer)
    {
        $this->request = $request;
        $this->response = $response;
        $this->loader = $loader;
        $this->renderer = $renderer;
    }

    public function execute()
    {
        try 
        {
            $response = $this->executeUserView();
            $view = new View;
            $view->foo = $response->foo;

            $this->response = $this->response
                ->withStatus(200)
                ->withBody(Psr7\stream_for(
                    $this->renderer->render(
                        'template', $view
                    )
                ));
        }
        catch (\Exception $e)
        {
            $this->response = $this->response
                ->withStatus(303)
                ->withHeader('Location', 'homepage');
        }
    }

    private function executeUserView()
    {
        $data = new Data;
        $data->a = $this->request->getQueryParams()['a'];
        $data->c = $this->request->getParsedBody()['c'];

        return $this->loader->load('User\View', [
            'Usecase\User\View' => [
                'Data\Data' => $data
            ]
        ])->execute();
    }
}
