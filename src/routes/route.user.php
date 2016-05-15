<?php

$app->map(['get'],'/user/{id}',function(\Slim\Http\Request $request,\Slim\Http\Response $response){
    $id = $request->getAttribute('id');
    $db = $this->get('db');
    $rs = $db->query('SELECT * FROM faker_user WHERE id = '.$id);
    $rs = $rs->fetchAll(\PDO::FETCH_ASSOC);
    $response->withJson($rs);
    return $response;
});