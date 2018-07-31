<?php

spl_autoload_register(function ($a) {
    (($b = __DIR__ . DIRECTORY_SEPARATOR . strtolower(str_replace('/', DIRECTORY_SEPARATOR, $a)) . '.php') && file_exists($b)) ? include_once $b : null;
});
