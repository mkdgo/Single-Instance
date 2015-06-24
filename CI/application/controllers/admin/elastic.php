<?php

/**
 * DOCUMENTATION:       http://elastica.io/
 * API DOCUMENTATION:   http://elastica.io/api/namespaces/Elastica.html
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Elastic extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index() {
        $this->_paste_admin(false, 'admin/elastic');
    }

    public function status() {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $response = $client->getStatus()->getData();
        $indexes = $response['indices'];

        $status = array();
        foreach ($indexes as $name => $index) {
            $status[$name] = array();
            $status[$name]['doc_count'] = $index['docs']['num_docs'];
            $shards = $index['shards'];
            foreach ($shards as $shard) {
                foreach ($shard as $k => $v) {
                    $status[$name]['shards'][$k] = $v['state'];
                }
            }
        }

        $this->session->set_flashdata('es_status', $status);

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function createindex() {
        $indexName = $this->input->post('indexname');

        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        try {
            $response = $client->getIndex($indexName)->create();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_createindex', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $data = $response->getData();
        if (array_key_exists('message', $data)) {
            $this->session->set_flashdata('es_createindex', $data['message']);
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_createindex', $response->getError());
        } else {
            $this->session->set_flashdata('es_createindex', 'Index "' . $indexName . '" created.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function deleteindex() {
        $indexName = $this->input->post('indexname');
        if (trim($indexName) === '') {
            $this->session->set_flashdata('es_deleteindex', 'You must specify an index.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        try {
            $response = $client->getIndex($indexName)->delete();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_deleteindex', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_deleteindex', $response->getError());
        } else {
            $this->session->set_flashdata('es_deleteindex', 'Index "' . $indexName . '" deleted.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function createtype() {
        $indexName = $this->input->post('indexname');
        if (trim($indexName) === '') {
            $this->session->set_flashdata('es_createtype', 'You must specify an index.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $typeName = $this->input->post('typename');
        if (trim($typeName) === '') {
            $this->session->set_flashdata('es_createtype', 'You must specify type.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex($indexName);
        $type = $index->getType($typeName);

        $mapping = new \Elastica\Type\Mapping();
        $mapping->setType($type);
        $mapping->setProperties(array(
            'id' => array('type' => 'integer', 'include_in_all' => FALSE)
        ));

        try {
            $response = $mapping->send();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_createtype', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_createtype', $response->getError());
        } else {
            $this->session->set_flashdata('es_createtype', 'Type "' . $typeName . '" in index "' . $indexName . '" created.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function deletetype() {
        $indexName = $this->input->post('indexname');
        if (trim($indexName) === '') {
            $this->session->set_flashdata('es_deletetype', 'You must specify an index.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $typeName = $this->input->post('typename');
        if (trim($typeName) === '') {
            $this->session->set_flashdata('es_deletetype', 'You must specify type.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex($indexName);
        $type = $index->getType($typeName);

        try {
            $response = $type->delete();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_deletetype', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_deletetype', $response->getError());
        } else {
            $this->session->set_flashdata('es_deletetype', 'Type "' . $typeName . '" in index "' . $indexName . '" deleted.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function createresourcetype() {
        $this->load->model('settings_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_createresourcetype', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex('dragonschool');
        if (!$index->exists()) {
            try {
                $client->getIndex($indexName)->create();
            } catch (\Elastica\Exception\ResponseException $e) {
                $this->session->set_flashdata('es_createresourcetype', $e->getMessage());
                redirect(base_url() . 'admin/elastic', 'refresh');
            }
        }

        $type = $index->getType('resources');
        if ($type->exists()) {
            $type->delete();
        }

        $mapping = new \Elastica\Type\Mapping();
        $mapping->setType($type);
        $mapping->setProperties(array(
            'id' => array(
                'type' => 'integer',
                'store' => true,
                'index' => 'not_analyzed'
            ),
            'teacher_id' => array(
                'type' => 'integer',
                'store' => true,
                'index' => 'not_analyzed'
            ),
            'resource_name' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'not_analyzed'
            ),
            'type' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'not_analyzed'
            ),
            'name' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'keywords' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'description' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'restriction_year' => array(
                'type' => 'short',
                'store' => true,
                'index' => 'not_analyzed'
            ),
            'active' => array(
                'type' => 'boolean',
                'store' => true,
                'index' => 'no',
                'include_in_all' => false
            ),
            'is_remote' => array(
                'type' => 'boolean',
                'store' => true,
                'index' => 'no',
                'include_in_all' => false
            ),
            'link' => array(
                'type' => 'string',
                'index' => 'not_analyzed',
                'norms' => array(
                    'enabled' => false
                )
            )
        ));

        try {
            $response = $mapping->send();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_createresourcetype', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_createresourcetype', $response->getError());
        } else {
            $this->session->set_flashdata('es_createresourcetype', 'Type "Resources" in default index ("' . $indexName . '") created.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function search1() {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $query = new \Elastica\Query();
        $qb = new \Elastica\QueryBuilder();

        $query->setQuery(
                $qb->query()
                        ->bool()
                        ->addShould(
                                $qb->query()->match('name', 'cold war events')
                        )
                        ->addShould(
                                $qb->query()->match('description', 'cold war events')
                        )
        );

        $search->setQuery($query);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    function search2() {
        echo "<pre>";
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $term = new \Elastica\Query\Term(array('restriction_year' => 7));
//        $term = new \Elastica\Query\Term(array('teacher_id' => 28));
//        $terms = new \Elastica\Query\Terms('restriction_year', array(9, 8, 3));

        $search->setQuery($term);
//        $search->setQuery($terms);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    function search3() {
        echo "<pre>";
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $query = new \Elastica\Query\Match();
        $query->setField('keywords', 'meme');
        $search->setQuery($query);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    function search4() {
        $id = intval($_GET['id']);
        echo "<pre>";
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex('dragonschool');
        $type = $index->getType('resources');

        $resource = $type->getDocument($id);

        echo '<br><pre>';
        print_r($resource);
        echo '<br></pre>';
    }

    function search5() {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $query1 = new \Elastica\Query\Match();
        $query1->setField('keywords', 'meme');

        $query3 = new \Elastica\Query\Match();
        $query3->setField('name', array(
            'query' => 'causes first',
            'boost' => 2
        ));

        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addShould($query1);
        $boolQuery->addShould($query3);

        $filter = new \Elastica\Filter\Term(array('restriction_year' => 7));

        $filtererQuery = new \Elastica\Query\Filtered($boolQuery, $filter);
//        echo '<br><pre>';
//        print_r($bool->toArray());
//        echo '<br></pre>';
//        die();
        $search->setQuery($filtererQuery);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    function delete1() {
        echo "<pre>";
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $term = new \Elastica\Query\Term(array('id' => 175));

        $query = new \Elastica\Query();
        $query->setQuery($term);
        $query->setFields(array('_id'));

        $search->setQuery($query);

        $results = $search->search(); //Array of \Elastica\Result objects

        echo '<strong>RESULTS</strong><br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';

        if (count($results) !== 1) {
            throw new Exception('Non-unique result exception');
        }

        $result = $results[0];
        $documentID = $result->getParam('_id');

        echo "DocumentID: $documentID<br>";

        $document = new \Elastica\Document($documentID);
        echo '<strong>THE DOCUMENT</strong><br><pre>';
        print_r($document);
        echo '<br></pre>';

        $index = $client->getIndex('dragonschool');
        $type = $index->getType('resources');
        $type->deleteDocument($document);
        $type->getIndex()->refresh();

        echo "DocumentID: $documentID deleted.<br>";
    }

    function listallresources() {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $results = $search->search();

        echo '<br><pre>';
        print_r($results);
        echo '<br></pre>';
    }

    function deleteallresources() {
        $this->load->model('settings_model');

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $query = new \Elastica\Query();
        $query->setQuery(new \Elastica\Query\MatchAll());
        $query->setFields(array('_id'));

        $search->setQuery($query);
        $results = $search->search();

        echo '<strong>RESULTS</strong><br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';

        $documents = array();

        foreach ($results as $result) {
            $documents[] = new \Elastica\Document($result->getParam('_id'));
        }

        echo "<hr>";
        echo '<strong>ALL DOCUMENTS</strong><br><pre>';
        print_r($documents);
        echo '<br></pre>';
        echo "<hr>";

        $index = $client->getIndex('dragonschool');
        $type = $index->getType('resources');
        $type->deleteDocuments($documents);
        $type->getIndex()->refresh();

        echo "All documents deleted.<br>";
    }

    function importresources() {
        $this->load->model('keyword_model');
        $this->load->model('resources_model');
        $this->load->model('settings_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_createresourcetype', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex('dragonschool');
        if (!$index->exists()) {
            $this->session->set_flashdata('es_importresources', 'Default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $type = $index->getType('resources');
        if (!$type->exists()) {
            $this->session->set_flashdata('es_importresources', '"Resources" type in default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $documents = array();
        $resources = $this->resources_model->get_all_resources();
        if (count($resources) === 0) {
            $this->session->set_flashdata('es_importresources', 'No resources found.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        foreach ($resources as $resource) {
            $years = explode(',', $resource->restriction_year);
            $restrictionYears = array();
            if (count($years) > 0) {
                foreach ($years as $year) {
                    if (trim($year) !== '') {
                        $restrictionYears[] = intval($year);
                    }
                }
            }

            $keywordsArray = $this->keyword_model->getResourceKeyword($resource->id);
            $keywords = array();
            foreach ($keywordsArray as $keyword) {
                $keywords[] = $keyword->word;
            }

            $documents[] = new \Elastica\Document(intval($resource->id), array(
                'id' => intval($resource->id),
                'teacher_id' => intval($resource->teacher_id),
                'resource_name' => $resource->resource_name,
                'type' => $resource->type,
                'name' => $resource->name,
                'keywords' => implode(' ', $keywords),
                'description' => $resource->description,
                'restriction_year' => $restrictionYears,
                'active' => (bool) $resource->active,
                'is_remote' => (bool) $resource->is_remote,
                'link' => $resource->link)
            );
        }

        $type->addDocuments($documents);
        $type->getIndex()->refresh();

        $this->session->set_flashdata('es_importresources', count($resources) . ' resources imported.');
        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function save() {
        $rawQuery = $this->input->post('search');
        echo "Your Query:<br><strong><pre>$rawQuery</pre></strong><br>";

        $queryArray = json_decode($rawQuery);
        echo "JSON ERROR:<br>";
        echo json_last_error_msg();
        echo '<br><pre>';
        print_r($queryArray);
        echo '<br></pre>';
//        redirect(base_url() . 'admin/settings', 'refresh');
    }

}
