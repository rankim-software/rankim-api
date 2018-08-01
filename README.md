# Api de integração Rankim (PHP)
Integração com a plataforma de marketing e CRM Rankim

[![GPL Licence](https://badges.frapsoft.com/os/gpl/gpl.svg?v=103)](https://opensource.org/licenses/GPL-3.0/) [![PHPPackages Rank](http://phppackages.org/p/smartdealer/sdapi/badge/rank.svg)](http://phppackages.org/p/rankim-software/rankim-api) ![](https://reposs.herokuapp.com/?path=rankim-software/rankim-api&style=flat)

Para mais informações, acesse o nosso [site](http://rankim.com.br).

Direitos reservados à Rankim Soluções de Software Ltda.

### Requísitos 

* PHP 5.3 ou superior
* Extensões do PHP "php_curl" e "php_openssl"
* Apache 2.2+

### Via composer

    composer require rankim-software/rankim-api

### Instância da API

~~~.php

// include autoload (direct, not needed by Composer)
include '../src/autoload.php';

OR

// if use composer (autoload)
require __DIR__ . '/vendor/autoload.php';

// instance API
$api = new \Rankim\Api('{id}', '{access_token}');

// get real estate listing
$data = $api->get('wallet');

// check errors
if ($api->getError()) {
    var_dump($api->getError());
}

// the output (array)
var_dump($data);  

~~~~

### Parâmetros da instância da classe

Tradução dos parâmetros

| paràmetro     | tipo         |  descrição  |
| ------------- | -------------| ------------- |
| id            | integer (11) | id do usuário da API
| access_token  | string (40)  | token de autenticação do usuário

### Funções da API

##### $api->auth()
Verificar se o ID e Token de usuários são válidos

##### $api->get('wallet')
Lista os imóveis da conta do usuário (retorno array)

##### $api->get('realty/123')
Trás informações de um imóvel específico na carteira (detalhes, imagens e características)

##### $api->put('lead', array(
    'name' => 'nome do lead',
    'email' => 'email do lead',
    'phone' => 'telefone do lead'
))

##### $api->getError()
Mostra os erros de execução da API

### Atualização regular

@Release 1.1.2/2018 
