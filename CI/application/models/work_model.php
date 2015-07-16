<?php

class Work_model extends CI_Model {

    private $main_table = 'work';
    private $assignments_table = 'work_assignments';
    private $items_table = 'work_items';
    private $items_temp_table = 'work_items_temp';
    private $taggees_table = 'work_taggees';
    private static $db;

    public function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public function insert_work($title, $subject, $created_by) {
        $this->db->set('title', $title);
        $this->db->set('subject', $subject);
        $this->db->set('created_by', $created_by, false);
        $this->db->set('created_on', 'NOW()', false);

        $this->db->insert($this->main_table);

        return $this->db->insert_id();
    }

    public function insert_work_item($work, $item_name, $item_type, $item_hash_name, $remote, $link) {
        $this->db->set('work', $work, false);
        $this->db->set('item_name', $item_name);
        $this->db->set('item_type', $item_type);
        $this->db->set('item_hash_name', $item_hash_name);
        $this->db->set('remote', $remote, false);
        $this->db->set('link', $link);

        $this->db->insert($this->items_table);

        return $this->db->insert_id();
    }

    public function insert_work_taggee($work, $taggedUser) {
        $this->db->set('work', $work, false);
        $this->db->set('tagged_user', $taggedUser, false);

        $this->db->insert($this->taggees_table);

        return $this->db->insert_id();
    }

    public function insert_work_assignment($work, $assignment) {
        $this->db->set('work', $work, false);
        $this->db->set('assignment', $assignment, false);

        $this->db->insert($this->assignments_table);

        return $this->db->insert_id();
    }

    public function insert_temp_work_item($uuid, $name = null, $type = null, $hashName = null, $remote = null, $link = null) {
        $this->db->set('uuid', $uuid);
        if ($name) {
            $this->db->set('item_name', $name);
        }
        if ($type) {
            $this->db->set('item_type', $type);
        }
        if ($hashName) {
            $this->db->set('item_hash_name', $hashName);
        }
        if ($remote !== null) {
            $this->db->set('remote', (bool) $remote);
        }
        if ($link) {
            $this->db->set('link', $link);
        }

        $this->db->insert($this->items_temp_table);

        return $this->db->insert_id();
    }

    public function get_work_temp_items_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        $this->db->from($this->items_temp_table);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_student_works_by_subject($student_id, $subject_id) {
        $this->db->select("work.id, work.title, date(work.created_on) AS created_on, subjects.name AS subject_name, CONCAT(users.first_name, ' ', users.last_name) AS tagger_name", false);
        $this->db->from($this->main_table);
        $this->db->join('work_taggees', 'work.id = work_taggees.work');
        $this->db->join('subjects', 'work.subject = subjects.id');
        $this->db->join('users', 'work.created_by = users.id');
        $this->db->where('work.subject', $subject_id, false);
        $this->db->where('work_taggees.tagged_user', $student_id, false);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_non_assignment_student_works_by_subject($student_id, $subject_id) {
        $this->db->select("work.id, work.title, date(work.created_on) AS created_on, subjects.name AS subject_name, CONCAT(users.first_name, ' ', users.last_name) AS tagger_name, work_assignments.id AS assignment_id", false);
        $this->db->from($this->main_table);
        $this->db->join('work_taggees', 'work.id = work_taggees.work');
        $this->db->join('subjects', 'work.subject = subjects.id');
        $this->db->join('users', 'work.created_by = users.id');
        $this->db->join('work_assignments', 'work.id = work_assignments.work', 'left');
        $this->db->where('work.subject', $subject_id, false);
        $this->db->where('work_taggees.tagged_user', $student_id, false);

        $query = $this->db->get();

        return $query->result();
    }

    public function get_work_items_for_assignment($assignment_id) {
        $this->db->select('*');
        $this->db->from($this->items_table);
        $this->db->where('work IN (SELECT work FROM work_assignments WHERE assignment = ' . $assignment_id . ')');
        $this->db->order_by('work ASC, id ASC');

        $query = $this->db->get();

        return $query->result();
    }

    public function update_work_item_with_resource_id($work_item_id, $resource_id) {
        $this->db->set('resource_id', $resource_id);
        $this->db->where('id', $work_item_id);
        
        $this->db->update($this->items_table);
    }
    public function get_work_item_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->items_table);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    public function delete_work_temp_items_by_uuid($uuid) {
        $this->db->where('uuid', $uuid);
        $this->db->delete($this->items_temp_table);
    }

    public function delete_temp_work_item($id, $uuid) {
        $this->db->where('id', $id);
        $this->db->where('uuid', $uuid);
        $this->db->delete($this->items_temp_table);
    }

}
