<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request; //importare le dipendenze
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");

$app->get('/alunni/{id}', "AlunniController:view");

// curl -X POST http://localhost:8080/alunni/2 -H "Content-Type: application/json" -d '{"nome": "ciccio"}'
$app->post('/alunni', "AlunniController:create");

// curl -X PUT http://localhost:8080/alunni/2 -H "Content-Type: application/json" -d '{"nome": "franko"}'
$app->put('/alunni/{id}', "AlunniController:update");

// curl -X DELETE http://localhost:8080/alunni/2
$app->delete('/alunni/{id}', "AlunniController:destroy");


$app->run();
