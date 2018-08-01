<?php

// add autoload
include '../src/autoload.php';

// instance API
$api = new \Rankim\Api(12345, '028f8a083f70c630b0b3dbb9fddda67d2604e345');

// auth user
var_dump($api->auth());

// get wallet
var_dump($api->get('wallet'));

// get one realty property
var_dump($api->get('realty/123456'));

// register new lead
var_dump($api->put('lead', array(
            'name' => 'Jhon Connor',
            'email' => 'john@rankim.com.br',
            'phone' => '+55 (099) 99999-9999' // or 9999999999
)));

// check errors
if ($api->getError()) {
    var_dump($apis->getError());
}
