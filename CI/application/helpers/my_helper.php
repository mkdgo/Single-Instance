<?php

class My_helpers {
    static $key = 'edifa';
    
    static public function homeworkGenerate( $params ) {
        $str_params = implode( ',', $params );
        $str_encoded = self::lime_encrypt( $str_params, self::$key );

//var_dump( 'http://77.72.3.90/convert.php?params='.$str_params );die;

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://77.72.3.90/convert.php?params='.$str_params,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        return $resp;
    }

    function lime_encrypt( $data, $key ) {
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data, MCRYPT_MODE_CBC, md5(md5($key))));
    }

    function lime_decrypt( $data,$key ) {
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }
}

?>
