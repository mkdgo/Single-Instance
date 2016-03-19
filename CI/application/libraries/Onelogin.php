<?php
 
class Onelogin{

    private $sett;

    function Onelogin() {
        @session_start();
        require_once dirname(__FILE__).'/php-saml/_toolkit_loader.php';
    }

    function OlAuth($SETT) {
        $this->sett = $SETT;
        return new OneLogin_Saml2_Auth( $this->sett );
    }
}
