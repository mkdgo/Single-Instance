<?php

/**
 * DOCUMENTATION:       http://elastica.io/
 * API DOCUMENTATION:   http://elastica.io/api/namespaces/Elastica.html
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//ini_set('SMTP', 'your.smtp.server');
class Elastic extends MY_Controller {
    public $client;

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }

    
        $this->load->model('settings_model');
        $host = $this->settings_model->getSetting('elastic_url');
        $this->load->library('storage'); // needs for elastica
        $this->client = new \Elastica\Client(array(
            'host' => $host,
            'port' => '80',
            'transport' => 'AwsAuthV4',
            'aws_region' => 'eu-central-1',
            'aws_access_key_id' => 'AKIAIRMCG6PRQHYH2RDA',
            'aws_secret_access_key' => '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',
//'aws_session_token'
        ));
    
    
    }

    function index() {
        $this->_paste_admin(false, 'admin/elastic');
    }

    public function status() {
//        $response = $client->getStatus()->getData();
        $response = $this->client->getStatus()->getResponse();
//        $indexes = $response['indices'];
        $indexes = $response->getShardsStatistics();
echo '<pre>';var_dump( $indexes );die;

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

echo '<pre>';var_dump( $response );die;
        $this->session->set_flashdata('es_status', $status);

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function createindex() {
        $indexName = $this->input->post('indexname');

        try {
            $response = $this->client->getIndex($indexName)->create();
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

        try {
            $response = $this->client->getIndex($indexName)->delete();
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

        $index = $this->client->getIndex($indexName);
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

        $index = $this->client->getIndex($indexName);
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

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_createresourcetype', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            try {
                $this->client->getIndex($indexName)->create();
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

    function createmoduletype() {

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_createmoduletype', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            try {
                $this->client->getIndex($indexName)->create();
            } catch (\Elastica\Exception\ResponseException $e) {
                $this->session->set_flashdata('es_createmoduletype', $e->getMessage());
                redirect(base_url() . 'admin/elastic', 'refresh');
            }
        }

        $type = $index->getType('modules');
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
            'name' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'intro' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'publish' => array(
                'type' => 'boolean',
                'store' => true,
                'index' => 'no',
                'include_in_all' => false
            ),
            'active' => array(
                'type' => 'boolean',
                'store' => true,
                'index' => 'no',
                'include_in_all' => false
            ),
            'subject_id' => array(
                'type' => 'integer',
                'store' => true
            ),
            'year_id' => array(
                'type' => 'integer',
                'store' => true
            )
        ));

        try {
            $response = $mapping->send();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_createmoduletype', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_createmoduletype', $response->getError());
        } else {
            $this->session->set_flashdata('es_createmoduletype', 'Type "Module" in default index ("' . $indexName . '") created.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function createlessontype() {

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_createlessontype', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            try {
                $this->client->getIndex($indexName)->create();
            } catch (\Elastica\Exception\ResponseException $e) {
                $this->session->set_flashdata('es_createlessontype', $e->getMessage());
                redirect(base_url() . 'admin/elastic', 'refresh');
            }
        }

        $type = $index->getType('lessons');
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
            'title' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'intro' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            ),
            'teacher_id' => array(
                'type' => 'integer',
                'store' => true
            ),
            'module_id' => array(
                'type' => 'integer',
                'store' => true
            ),
            'active' => array(
                'type' => 'boolean',
                'store' => true,
                'index' => 'no',
                'include_in_all' => false
            )
        ));

        try {
            $response = $mapping->send();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_createlessontype', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_createlessontype', $response->getError());
        } else {
            $this->session->set_flashdata('es_createlessontype', 'Type "Lesson" in default index ("' . $indexName . '") created.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function createstudenttype() {
        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_createstudenttype', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            try {
                $this->client->getIndex($indexName)->create();
            } catch (\Elastica\Exception\ResponseException $e) {
                $this->session->set_flashdata('es_createstudenttype', $e->getMessage());
                redirect(base_url() . 'admin/elastic', 'refresh');
            }
        }

        $type = $index->getType('students');
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
            'fullname' => array(
                'type' => 'string',
                'store' => true,
                'index' => 'analyzed'
            )
        ));

        try {
            $response = $mapping->send();
        } catch (\Elastica\Exception\ResponseException $e) {
            $this->session->set_flashdata('es_createstudenttype', $e->getMessage());
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $statusCode = $response->getStatus();
        if ($statusCode !== 200) {
            $this->session->set_flashdata('es_createstudenttype', $response->getError());
        } else {
            $this->session->set_flashdata('es_createstudenttype', 'Type "Student" in default index ("' . $indexName . '") created.');
        }

        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function search1() {
        $search = new \Elastica\Search($this->client);
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
        $search = new \Elastica\Search($this->client);
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
        $search = new \Elastica\Search($this->client);
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
        $index = $this->client->getIndex('dragonschool');
        $type = $index->getType('resources');

        $resource = $type->getDocument($id);

        echo '<br><pre>';
        print_r($resource);
        echo '<br></pre>';
    }

    function search5() {
        $search = new \Elastica\Search($this->client);
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

    public function search6() {
        echo "URL: " . $this->settings_model->getSetting('elastic_url') . "<br>";
        echo "INDEX: " . $this->settings_model->getSetting('elastic_index') . "<br>";
        echo '<pre>';

        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('modules');

        $boolFilter = new \Elastica\Filter\Bool();

        $boolTerm1 = new \Elastica\Filter\Term(array('year_id' => 21));
        $boolFilter->addShould($boolTerm1);

        $boolTerm2 = new \Elastica\Filter\Term(array('year_id' => 25));
        $boolFilter->addShould($boolTerm2);

        $term1 = new \Elastica\Query\Term(array('year_id' => 26));
        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addShould($term1);

        $filtererQuery = new \Elastica\Query\Filtered(null, $boolFilter);

        echo '<br><pre>';
        print_r($filtererQuery->toArray());
        echo '<br></pre>';

        $search->setQuery($filtererQuery);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    public function search7() {
        echo "URL: " . $this->settings_model->getSetting('elastic_url') . "<br>";
        echo "INDEX: " . $this->settings_model->getSetting('elastic_index') . "<br>";
        echo '<pre>';

        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('lessons');

        $boolFilter = new \Elastica\Filter\Bool();

        $boolTerm1 = new \Elastica\Filter\Term(array('module_id' => 71));
        $boolFilter->addShould($boolTerm1);

        $filtererQuery = new \Elastica\Query\Filtered(null, $boolFilter);

        echo '<br><pre>';
        print_r($filtererQuery->toArray());
        echo '<br></pre>';

        $search->setQuery($filtererQuery);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    public function search8() {
        $query = 'ben';
        
        echo "URL: " . $this->settings_model->getSetting('elastic_url') . "<br>";
        echo "INDEX: " . $this->settings_model->getSetting('elastic_index') . "<br>";
        echo '<pre>';

        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('students');

        $nameQuery = new \Elastica\Query\Match();
        $nameQuery->setField('fullname', array(
            'query' => trim($query)
        ));

        $search->setQuery($nameQuery);

        $results = $search->search();
        echo '<br><pre>';
        print_r($results);
        echo '<br></pre>';
    }

    function delete1() {
        echo "<pre>";
        $search = new \Elastica\Search($this->client);
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

        $index = $this->client->getIndex('dragonschool');
        $type = $index->getType('resources');
        $type->deleteDocument($document);
        $type->getIndex()->refresh();

        echo "DocumentID: $documentID deleted.<br>";
    }

    function listallresources() {
        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('resources');

        $results = $search->search();

        echo '<br><pre>';
        print_r($results);
        echo '<br></pre>';
    }

    function listallmodules() {
        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('modules');

        $results = $search->search();

        echo '<br><pre>';
        print_r($results);
        echo '<br></pre>';
    }

    function listalllessons() {
        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('lessons');

        $results = $search->search();

        echo '<br><pre>';
        print_r($results);
        echo '<br></pre>';
    }

    function listallstudents() {
        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('students');

        $results = $search->search();

        echo '<br><pre>';
        print_r($results);
        echo '<br></pre>';
    }

    function deleteallresources() {
        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->settings_model->getSetting('elastic_index'))->addType('resources');

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

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        $type = $index->getType('resources');
        $type->deleteDocuments($documents);
        $type->getIndex()->refresh();

        echo "All documents deleted.<br>";
    }

    function importresources() {
        $this->load->model('keyword_model');
        $this->load->model('resources_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_importresources', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
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

    function importmodules() {
        $this->load->model('modules_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_importmodules', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            $this->session->set_flashdata('es_importmodules', 'Default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $type = $index->getType('modules');
        if (!$type->exists()) {
            $this->session->set_flashdata('es_importmodules', '"Module" type in default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $documents = array();
        $modules = $this->modules_model->get_all_modules();
        if (count($modules) === 0) {
            $this->session->set_flashdata('es_importmodules', 'No modules found.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        foreach ($modules as $module) {
            $documents[] = new \Elastica\Document(intval($module->id), array(
                'id' => intval($module->id),
                'name' => $module->name,
                'intro' => $module->intro,
                'publish' => (bool) $module->publish,
                'active' => (bool) $module->active,
                'subject_id' => intval($module->subject_id),
                'year_id' => intval($module->year_id))
            );
        }

        $type->addDocuments($documents);
        $type->getIndex()->refresh();

        $this->session->set_flashdata('es_importmodules', count($modules) . ' modules imported.');
        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function importlessons() {
        $this->load->model('lessons_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_importmodules', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            $this->session->set_flashdata('es_importlessons', 'Default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $type = $index->getType('lessons');
        if (!$type->exists()) {
            $this->session->set_flashdata('es_importmodules', '"Lesson" type in default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $documents = array();
        $lessons = $this->lessons_model->get_all_lessons();
        if (count($lessons) === 0) {
            $this->session->set_flashdata('es_importlessons', 'No lessons found.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        foreach ($lessons as $lesson) {
            $documents[] = new \Elastica\Document(intval($lesson->id), array(
                'id' => intval($lesson->id),
                'title' => $lesson->title,
                'intro' => $lesson->intro,
                'teacher_id' => intval($lesson->teacher_id),
                'module_id' => intval($lesson->module_id),
                'active' => (bool) $lesson->active)
            );
        }

        $type->addDocuments($documents);
        $type->getIndex()->refresh();

        $this->session->set_flashdata('es_importlessons', count($lessons) . ' lessons imported.');
        redirect(base_url() . 'admin/elastic', 'refresh');
    }

    function importstudents() {
        $this->load->model('user_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            $this->session->set_flashdata('es_importstudents', 'Default index name not set.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $index = $this->client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            $this->session->set_flashdata('es_importstudents', 'Default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $type = $index->getType('students');
        if (!$type->exists()) {
            $this->session->set_flashdata('es_importstudents', '"Student" type in default index does not exist.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        $documents = array();
        $students = $this->user_model->get_all_students();
        if (count($students) === 0) {
            $this->session->set_flashdata('es_importstudents', 'No students found.');
            redirect(base_url() . 'admin/elastic', 'refresh');
        }

        foreach ($students as $student) {
            $documents[] = new \Elastica\Document(intval($student->id), array(
                'id' => intval($student->id),
                'fullname' => trim($student->first_name) . ' ' . trim($student->last_name))
            );
        }

        $type->addDocuments($documents);
        $type->getIndex()->refresh();

        $this->session->set_flashdata('es_importstudents', count($students) . ' students imported.');
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
