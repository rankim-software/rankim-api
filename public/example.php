<?php

// incluse API class
include '../src/rankim/api.php';
include '../src/rankim/server.php';

// instance server
$srv = new \Rankim\Server('{access_token}', '{db_host}', '{db_user}', '{db_pass}', '{db_name}', '{db_port}');

// set query
$srv->query("codigo, titulo, descricao, preco, imagens FROM imoveis ORDER by titulo");

// start server
$srv->run();

// check errors
if ($srv->getError()) {
    var_dump($srv->getError());
}