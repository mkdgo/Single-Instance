<?php

/**
 * http://elastica.io/
 * API: http://elastica.io/api/namespaces/Elastica.html
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Elastic extends MY_Controller {

    private $host = '';

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index() {
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $term = new \Elastica\Query\Term(array('years' => 32));
        $search = new \Elastica\Search($client);
        $search->addIndex('hoyya')
                ->addType('resources')
                ->setQuery($term);

        $results = $search->search()->getResults();

        $query = '';

        $this->_data['query'] = $query;

        $this->_paste_admin(false, 'admin/elastic');
    }

    function createindex() {
        //    http://ediface-master.dev/admin/elastic/createindex?indexname=YOUR_INDEX_NAME
        $indexName = $_GET['indexname'];

        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $client->getIndex($indexName)->create();

        echo 'created index "<strong>' . $indexName . '</strong>"';
    }

    function deleteindex() {
        //    http://ediface-master.dev/admin/elastic/deleteindex?indexname=YOUR_INDEX_NAME
        $indexName = $_GET['indexname'];

        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $client->getIndex($indexName)->delete();

        echo 'deleted index "<strong>' . $indexName . '</strong>"';
    }

    function createtype() {
        echo '<pre>';
        //    http://ediface-master.dev/admin/elastic/createtype?indexname=YOUR_INDEX_NAME&typename=YOUR_TYPE_NAME
        $indexName = $_GET['indexname'];
        $typeName = $_GET['typename'];

        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $index = $client->getIndex($indexName);
        $type = $index->getType($typeName);

        $mapping = new \Elastica\Type\Mapping();
        $mapping->setType($type);
        $mapping->setProperties(array(
            'id' => array('type' => 'integer', 'include_in_all' => FALSE)
        ));
        $mapping->send();

        echo 'created type "<strong>' . $typeName . '</strong>" in index "<strong>' . $indexName . '</strong>"';
    }

    function deletetype() {
        //    http://ediface-master.dev/admin/elastic/deletetype?indexname=YOUR_INDEX_NAME&typename=YOUR_TYPE_NAME
        $indexName = $_GET['indexname'];
        $typeName = $_GET['typename'];
        echo "<pre>";
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $index = $client->getIndex($indexName);
        $type = $index->getType($typeName);
        $type->delete();

        echo 'deleted type "<strong>' . $typeName . '</strong>" in index "<strong>' . $indexName . '</strong>"';
    }

    function createresourcetype() {
        //    http://ediface-master.dev/admin/elastic/createresourcetype

        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $index = $client->getIndex('dragonschool');
        $type = $index->getType('resources');

        $mapping = new \Elastica\Type\Mapping();
        $mapping->setType($type);
        $mapping->setProperties(array(
            'id' => array(
                'type' => 'integer',
                'store' => true,
                'index' => 'no',
                'include_in_all' => false
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
        $mapping->send();
    }

    function search1() {
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

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
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

//        $term = new \Elastica\Query\Term(array('restriction_year' => 3));
        $term = new \Elastica\Query\Term(array('teacher_id' => 28));
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
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $term = new \Elastica\Query\Term(array('type' => 'ediface'));

        $search->setQuery($term);

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    function listallresources() {
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $search = new \Elastica\Search($client);
        $search->addIndex('dragonschool')->addType('resources');

        $results = $search->search();

        echo '<br><pre>';
        print_r($results->getResults());
        echo '<br></pre>';
    }

    function importresources() {
        $this->load->library('elastica');
        $client = $this->elastica->getClient();

        $index = $client->getIndex('dragonschool');
        $type = $index->getType('resources');

        $this->load->model('resources_model');
        $ids = array(175, 178, 179, 182, 183);

        $documents = array();
        foreach ($ids as $id) {
            $resource = $this->resources_model->get_resource_by_id($id);
            $years = explode(',', $resource->restriction_year);
            $restrictionYears = array();
            if (count($years) > 0) {
                foreach ($years as $year) {
                    if (trim($year) !== '') {
                        $restrictionYears[] = intval($year);
                    }
                }
            }

            $documents[] = new \Elastica\Document(intval($resource->id), array(
                'id' => intval($resource->id),
                'teacher_id' => intval($resource->teacher_id),
                'resource_name' => $resource->resource_name,
                'type' => $resource->type,
                'name' => $resource->name,
                'keywords' => $resource->keywords,
                'description' => $resource->description,
                'restriction_year' => $restrictionYears,
                'active' => (bool) $resource->active,
                'is_remote' => (bool) $resource->is_remote,
                'link' => $resource->link)
            );

//            $document = array(
//                'id' => $resource->id,
//                'teacher_id' => $resource->teacher_id,
//                'resource_name' => $resource->resource_name,
//                'type' => $resource->type,
//                'name' => $resource->name,
//                'keywords' => $resource->keywords,
//                'description' => $resource->description,
//                'restriction_year' => $restrictionYears,
//                'active' => $resource->active,
//                'is_remote' => $resource->is_remote,
//                'link' => $resource->link
//            );
//
//            echo '<br><pre>';
//            print_r($document);
//            echo '<br></pre>';
        }

        if (count($documents) > 0) {
            $type->addDocuments($documents);
            $type->getIndex()->refresh();
            echo "imported<br>";
        } else {
            echo "Exception<br>";
        }
    }

    function save() {
        $updateData = array();
        $allSettings = array_keys($this->settings_model->getAllSettingsAsAssocArray());

        foreach ($allSettings as $key) {
            $updateData[$key] = $this->input->post($key, TRUE);
        }

        $this->settings_model->updateSiteSettings($updateData);

        redirect(base_url() . 'admin/settings', 'refresh');
    }

}
