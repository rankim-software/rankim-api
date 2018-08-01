<?php

/**
 * Rankim client API
 *
 * @package   Rankim
 * @author    Patrick Otto <patrick@rankim.com.br>
 * @version   1.1.2
 * @access    public
 * @copyright Rankim Software (c), 2016-2018
 * @see       https://rankim.com.br
 */

namespace Rankim;

class Api {

    const API_HOST = 'https://sistema.rankim.com.br/ws/api/';

    private $error = array(), $user_id, $user_token;

    public function __construct($a, $b) {

        // check format
        if (!is_numeric($a) OR ! is_string($b) OR mb_strlen($b) < 40) {
            return;
        }

        // save
        $this->user_id = $a;
        $this->user_token = $b;
    }

    public function auth($params = array()) {

        $ch = curl_init();

        // set params
        $params += array(
            'id' => $this->user_id,
            'access_token' => $this->user_token
        );

        // set curl
        curl_setopt($ch, CURLOPT_URL, self::API_HOST . 'auth?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // request
        $r = curl_exec($ch);

        // close
        curl_close($ch);

        // return
        return ($r) ? $this->prepareJSON($r) : false;
    }

    public function get($method, $params = array()) {

        $ch = curl_init();

        // set params
        $params += array(
            'id' => $this->user_id,
            'access_token' => $this->user_token
        );

        // set curl
        curl_setopt($ch, CURLOPT_URL, self::API_HOST . $method . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // request
        $r = curl_exec($ch);

        // close
        curl_close($ch);

        // return
        return ($r) ? $this->prepareJSON($r) : false;
    }

    public function put($method, $data = array(), $params = array()) {


        $ch = curl_init();

        // set params
        $params += array(
            'id' => $this->user_id,
            'access_token' => $this->user_token
        );

        // set curl
        curl_setopt($ch, CURLOPT_URL, self::API_HOST . $method . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // request
        $r = curl_exec($ch);
        
        // close
        curl_close($ch);

        // return
        return ($r) ? $this->prepareJSON($r) : false;
    }

    private function setError($a) {
        $this->error[] = $a;
    }

    public function getError() {
        return array_unique((array) ($this->error));
    }

    public function prepareJSON($a, $is_file = false) {

        if ($is_file && is_file($a)) {
            $a = file_get_contents($a);
        } elseif ($is_file) {
            $a = false;
        }

        // valid and convert
        if ($a && (stristr($a, '[') OR stristr($a, '{'))) {
            try {
                $b = json_decode($a);
            } catch (Exception $e) {
                // ignore
            }
        }

        // return
        return (!empty($b) && (is_array($b) or is_object($b)) && (json_last_error() === JSON_ERROR_NONE)) ? $b : array();
    }

}
