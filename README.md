# Api de integração Rankim (PHP)
Integração com a plataforma imobiliária Rankim

[![GPL Licence](https://badges.frapsoft.com/os/gpl/gpl.svg?v=103)](https://opensource.org/licenses/GPL-3.0/) [![PHPPackages Rank]
(http://phppackages.org/p/smartdealer/sdapi/badge/rank.svg)](http://phppackages.org/p/rankim-software/rankim-api) ![](https://reposs.herokuapp.com/?path=rankim-software/rankim-api&style=flat)

Para mais informações, acesse o nosso [site](http://rankim.com.br).

Direitos reservados à Rankim Soluções de Software Ltda.

### Requísitos 

* PHP 5.3 ou superior
* Extensões do PHP "php_curl" e "php_openssl"
* Apache 2.2+
* Apache Mod Rewrite ativo (.htaccess) 
* MySQL versão 5+

### Use via composer

    composer require rankim-software/rankim-api

### API em modo servidor

~~~.php

 // incluse API class
include '../src/rankim/api.php';
include '../src/rankim/server.php';

// instance server
$srv = new \Rankim\Server('{access_token}', '{db_host}', '{db_user}', '{db_pass}', '{db_name}', '{db_port}');

// set query (example)
$srv->query("SELECT codigo, titulo, descricao, preco, imagens FROM imoveis ORDER by titulo");

// start server
$srv->run();

// check errors
if ($srv->getError()) {
    var_dump($srv->getError());
}
  
~~~~

A API deverá ser instalada em uma rota pública acessível via **URL**. Após validação com a função "$srv->run()", o endereço da API instalada deverá ser configurado na *plataforma Rankim*, em integrações.

### Parâmetros da instância da classe

Tradução dos parâmetros

| campo         | tipo         |  descrição  |
| ------------- | -------------| ------------- |
| access_token  | string (40)  | token de autenticação do usuário
| db_host       | string       | endereço ou IP do servidor MySQL
| db_user       | string       | nome do usuário do banco de dados
| db_pass       | string       | senha do usuário do banco de dados
| db_name       | string       | nome do banco de dados
| db_port       | integer      | porta de conexão* (opcional)

### Funções da API (modo sservidor)

##### $srv->query("SQL")
Configura a SQL query a ser executa pela API

##### $srv->run()
Inicializa o servidor, validando os campos e compila os dados para exibição (formato JSON)

##### $srv->getError()
Mostra os erros de execução da API

### Atualização regular

@Release 1.0 

Nota da versão:

Em breve mais novidades.
