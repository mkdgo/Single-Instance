<?php

spl_autoload_register('Elastica_Register_Linux::register');

class Elastica_Register_Linux {

    const CI_PREFIX = "CI_";

    public static function register($insClass) {
        $sPrefix = substr($insClass, 0, 3);

        if ($sPrefix == self::CI_PREFIX) {
            return;
        }

        $sFile = APPPATH . 'libraries' . DIRECTORY_SEPARATOR . $insClass . EXT;

        if (file_exists($sFile)) {
            require_once $sFile;
        }
    }

}
