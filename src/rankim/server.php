<?php

/**
 * Rankim Rest Client API
 *
 * @package   Rankim
 * @author    Patrick Otto <patrick@rankim.com.br>
 * @version   1.0.0
 * @access    public
 * @copyright Rankim Software (c), 2016
 * @see       http://rankim.com.br
 */

namespace Rankim;

require_once 'schema.php';

class Server extends \Rankim\Schema {

    protected $query, $conn, $token;

    /* PHP dependecies */
    private $depends = array(
        'mysqli',
        'curl',
        'openssl'
    );

    const MIN_RELEASE_PHP = 5.3;
    const DEBUG = false;

    public function __construct($a, $b, $c, $d, $e, $port = 3306) {

        // check dependencies
        $this->check();

        // set token
        $this->token($a);

        // auth by token
        $this->auth();

        // connect from database
        $this->connect($b, $c, $d, $e, $port);
    }

    private function check() {

        // reset
        $this->error = array();

        $v = ((float) phpversion());

        if ($v < self::MIN_RELEASE_PHP) {
            $this->error[] = 'the PHP version "' . $v . '" is not compatible (' . self::MIN_RELEASE_PHP . ' or later)';
        }

        foreach ($this->depends AS $ext) {
            if (!extension_loaded($ext)) {
                $this->error[] = 'the extension "' . $ext . '" not loaded by PHP';
            }
        }
    }

    private function auth() {

        // valid token
        $b = ($this->token && ($a = filter_input(INPUT_GET, 'access_token')) && $a === $this->token);

        if (!$b) {
            $this->show_404();
        }
    }

    public function run() {

        if (!$this->query OR ! (is_object($this->conn) && get_class($this->conn) && !$this->conn->errno)) {

            $this->error[] = 'The SQL query or database connection is invalid' . $this->dbError();

            // return
            return false;
        }

        $a = mysqli_query($this->conn, $this->query);

        if ($a && mysqli_num_rows($a)) {
            $this->fetch_data($a);
        } else {
            $this->error[] = 'SQL' . $this->dbError();
        }
    }

    private function dbError() {
        return ($this->conn) ? ': ' . mysqli_error($this->conn) : null;
    }

    private function connect($a, $b, $c, $d, $port) {

        // encapsulate
        try {

            ob_start();
            $this->conn = mysqli_connect($a, $b, $c, $d, $port);
            ob_clean();

            if (!$this->conn) {
                throw new \Exception('Unable to connect');
            } else {
                mysqli_set_charset($this->conn, "utf8");
            }
            
        } catch (\Exception $e) {
            $this->error[] = 'Database response "' . $e->getMessage() . '" (host, user, pass, database or port is invalid)';
        }
    }

    public function query($q) {
        if ($this->valid($q)) {
            $this->query = (string) ($q);
        }
    }

    private function fetch_data($a) {

        // valid schema
        $c = ($a) ? $this->validSchema(mysqli_fetch_assoc($a)) : null;

        // compile data
        $b = ($c && $a) ? mysqli_fetch_all($a, MYSQL_ASSOC | MYSQLI_NUM) : array();

        // output
        if (!$b) {
            return false;
        }

        $json = json_encode($b);

        // valid
        if (!$json) {
            $this->error[] = 'JSON encode error: ' . json_last_error_msg();
        } else {

            header('Content-Type: application/json');
            die($json);
        }
    }

    public function valid($q) {

        preg_match_all('/select|from/i', $q, $a);

        // check string matchs
        if (empty($a[0]) or ( $b = (count($a[0]) < 2))) {
            $this->error[] = 'the SQL query is invalid: ' . trim($q);
        }

        return (bool) (!$b);
    }

    protected function token($a = null) {

        if (is_null($a) && $this->token) {
            return $this->token;
        }

        if (strlen($a) === 40) {
            $this->token = $a;
        } else {
            $this->error[] = 'the access token is not valid (' . $a . ') min 40 characters';
        }
    }

    public function show_404() {
        header("HTTP/1.0 404 Not Found");
        die("<h1>The server is unavailable</h1>");
    }

    public function getError() {
        return array_unique($this->error);
    }
}