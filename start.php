<?php 
error_reporting(E_ALL);



   $fp = fsockopen("10.42.0.2", 80);
fputs($fp, "POST /SETPARAMS HTTP/1.1\r\n");
fputs($fp, "Host: E-Wall\r\n");
fputs($fp, "Content-Type: application/octet-stream\r\n");
fputs($fp, "Content-Length: 5\r\n");
fputs($fp, "Connection: close\r\n\r\n");
//изпращане на "1" на параметър с индекс "0" (старт на играта)
fputs($fp, hex2bin("0000000001"), 5);

//изпращане на "8" на параметър с индекс "2" (старт на играта)
//fputs($fp, hex2bin("0200000008"), 5);

stream_get_contents($fp);
//$file='data.txt';
//file_put_contents($file,bin2hex(fread($in,4)),FILE_APPEND);
//$r = stream_get_contents($fp);



fclose($fp);
//var_dump($r);
echo "SENT";
?>
