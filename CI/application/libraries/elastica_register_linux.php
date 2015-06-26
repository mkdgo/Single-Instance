<?php

spl_autoload_register('Elastica_Register_Linux::register');

class Elastica_Register_Linux {

    const CI_PREFIX = "CI_";

    public static function register($insClass) {
        $sPrefix = substr($insClass, 0, 3);

        if ($sPrefix == self::CI_PREFIX) {
            return;
        }

        $vars = array();
        if (strtolower(substr($insClass, 0, 8)) === 'elastica') {
            $vars = explode('\\', $insClass);
        }

        if (count($vars) > 0) {
            require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $vars) . '.php';
        }
    }

}
