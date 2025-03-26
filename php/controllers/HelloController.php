<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HelloController
{
  public function hello(Request $request, Response $response, $args){ //vengono gestite le rotte intercettate dalla index
    $response->getBody()->write("Hello");
    return $response;
  }

  public function hello_name(Request $request, Response $response, $args){
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
  }

  public function json_name(Request $request, Response $response, $args){
    $name = $args['name'];
    $response->getBody()->write("{'nome': '$name'}");
    return $response-> withHeader('Content-Type', 'application/json');
  }
}
