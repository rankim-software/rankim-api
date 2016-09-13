<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace rankim;

class Schema {

    protected $error;
    private $schema = array(
        'codigo' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 1
        ),
        'titulo' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 10
        ),
        'descricao' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 0
        ),
        'tipo' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 3
        ),
        'negociacao' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 3
        ),
        'cidade' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 1
        ),
        'bairro' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 1
        ),
        'uf' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 2
        ),
        'quadra' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 0
        ),
        'bloco' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 0
        ),
        'numero' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 0
        ),
        'complemento' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 0
        ),
        'n_quartos' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 0
        ),
        'n_suites' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 0
        ),
        'n_banheiros' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 0
        ),
        'n_garagens' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 0
        ),
        'area_total' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 0
        ),
        'area_util' => array(
            'type' => 'integer',
            'pattern' => '',
            'min_length' => 0
        ),
        'latitudade' => array(
            'type' => 'float',
            'pattern' => '',
            'min_length' => 0
        ),
        'longitude' => array(
            'type' => 'float',
            'pattern' => '',
            'min_length' => 0
        ),
        'valor' => array(
            'type' => 'float',
            'pattern' => '',
            'min_length' => 2
        ),
        'valor_mensal' => array(
            'type' => 'float',
            'pattern' => '',
            'min_length' => 0
        ),
        'valor_entrada' => array(
            'type' => 'float',
            'pattern' => '',
            'min_length' => 0
        ),
        'observacoes' => array(
            'type' => 'string',
            'pattern' => '',
            'min_length' => 0
        ),
        'imagens' => array(
            'type' => 'string',
            'pattern' => '/jp[e]?g|png/im',
            'min_length' => 0
        )
    );

    protected function validSchema(Array $a) {
        foreach ($a AS $col => $val) {
            if (!key_exists($col, $this->schema)) {
                continue;
            }

            // prepare
            if (is_numeric($val) && in_array($this->schema[$col]['type'], array('integer', 'float', 'real', 'double'))) {
                $val = eval('return (' . $this->schema[$col]['type'] . ') (' . $val . ');');
            }

            $length = strlen($val);
            $type = gettype($val);

            if ($type === 'double') {
                $type = 'float';
            }

            if ($val && !empty($this->schema[$col]['type']) && $this->schema[$col]['type'] !== $type) {
                $this->error[] = 'SQL Schema: "' . $col . '" (' . $type . ') is not type ' . strtoupper($this->schema[$col]['type']);
            }

            if ($val && !empty($this->schema[$col]['pattern']) && !preg_match($this->schema[$col]['pattern'], $val)) {
                $this->error[] = 'SQL Schema: "' . $col . '" is not compatible with pattern ' . $this->schema[$col]['pattern'];
            }

            if ($val && !empty($this->schema[$col]['min_length']) && $length < $this->schema[$col]['min_length']) {
                $this->error[] = 'SQL Schema: "' . $col . '" (' . $length . ') not have minimum length of ' . $this->schema[$col]['min_length'] . ' chars';
            }
        }


        // return
        return (bool) (!$this->error);
    }

}