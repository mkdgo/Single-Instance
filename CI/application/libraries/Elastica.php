<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Elastica {

    private static $factory;
    private $client = null;
    private $host = null;

    public function __construct() {
        $ci = & get_instance();
        $ci->config->load("elasticsearch");
        $this->host = $ci->config->item('elasticsearch_host');
    }

    public function getClient() {
        if (!$this->client) {
            $this->client = new \Elastica\Client(array(
                'host' => $this->host
            ));
        }

        return $this->client;
    }

}
