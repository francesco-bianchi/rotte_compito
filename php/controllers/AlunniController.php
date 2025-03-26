<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    if(isset($_GET["search"])){
      $parametri = $request->getQueryParams();
      $search = $parametri['search'];

      $query = "SELECT * FROM alunni WHERE nome LIKE '%$search%' OR cognome LIKE '%$search%'";

      if(isset($_GET["sortCol"]) && isset($_GET["sort"])){
        $sortCol = $parametri["sortCol"];
        $sort = $parametri["sort"];
        $query .= "ORDER BY $sortCol $sort";
      }

      $result = $mysqli_connection->query($query);

      if($result){
        $response->getBody()->write(json_encode(array("message"=>"success")));
        $status = 200;
      }
      else{
        $response->getBody()->write(json_encode(array("message"=> $mysqli_connection->error)));
        $status = 404;
      }
    }
    else{
      $result = $mysqli_connection->query("SELECT * FROM alunni");
      $status = 200;
    }
    
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus($status);
  }

  public function view(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE id = '$args[id]'");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query_inserimento = "INSERT INTO alunni(nome, cognome, cf) VALUES('$body[nome]', '$body[cognome]', '$body[cf]');";
    $result = $mysqli_connection->query($query_inserimento);
    if($result){
      $response->getBody()->write(json_encode(array("message"=>"success")));
      $status = 201;
    }
    else{
      $response->getBody()->write(json_encode(array("message"=> $mysqli_connection->error)));
      $status = 404;
    }
    

    return $response->withHeader("Content-type", "application/json")->withStatus($status);
  }

  public function update(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query_inserimento = "UPDATE alunni SET";
    if(isset($body["nome"])){
      $query_inserimento .= " nome='$body[nome]'";
    }

    if(isset($body["cognome"]) && !isset($body["nome"])){
      $query_inserimento .= " cognome='$body[cognome]'";
    }
    else if(isset($body["cognome"])){
      $query_inserimento .= ", cognome='$body[cognome]'";
    }

    if(isset($body["cf"]) && !isset($body["nome"]) && !isset($body["cognome"])){
      $query_inserimento .= " cf='$body[cf]'";
    }
    else if(isset($body["cf"])){
      $query_inserimento .= ", cf='$body[cf]'";
    }

    $query_inserimento .= " WHERE id = '$args[id]'";

    $result = $mysqli_connection->query($query_inserimento);
    if($result){
      $response->getBody()->write(json_encode(array("message"=>"success")));
      $status = 200;
    }
    else{
      $response->getBody()->write(json_encode(array("message"=> $mysqli_connection->error)));
      $status = 404;
    }
    

    return $response->withHeader("Content-type", "application/json")->withStatus($status);
  }

  public function destroy(Request $request, Response $response, $args){
    $body = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query_inserimento = "DELETE FROM alunni WHERE id = '$args[id]'";
    $result = $mysqli_connection->query($query_inserimento);
    if($result){
      $response->getBody()->write(json_encode(array("message"=>"success")));
      $status = 200;
    }
    else{
      $response->getBody()->write(json_encode(array("message"=> $mysqli_connection->error)));
      $status = 404;
    }
    

    return $response->withHeader("Content-type", "application/json")->withStatus($status);
  }

  public function search_sort(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    
  }
}
