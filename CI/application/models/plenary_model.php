<?php

class Plenary_model extends CI_Model {

    private static $_plenariesTable = 'plenaries';
    private static $_plenaryGridTable = 'plenary_grid';
    private static $_plenaryLabelsTable = 'plenary_grade_labels';
    private $_plenaryType = '';
    private $_plenaryForeignTable = '';
    private $_plenaryKeywordsTable = '';
    private $_fkId = 0;

    public function init($plenary_type, $fk_id) {
        // $plenary_type is either 'module' or 'lesson'
        $this->_plenaryType = strtolower($plenary_type);
        $this->_fkId = intval($fk_id);
        $this->_plenaryForeignTable = $this->_plenaryType . 's';
        $this->_plenaryKeywordsTable = 'key_words_' . $this->_plenaryType . 's';

        return $this;
    }

    public function insertPlenary() {
        if (!$this->validConfiguration()) {
            return 0;
        }

        $this->db->set('plenary_type', $this->_plenaryType);
        $this->db->set('fk_id', $this->_fkId);
        $this->db->insert(self::$_plenariesTable);

        $plenaryId = $this->db->insert_id();

        $this->createPlenaryGrid($plenaryId);
        
        return $plenaryId;
    }

    private function createPlenaryGrid($plenaryId) {
        $labelIDs = array();
        $this->db->select('id');
        $this->db->order_by('label_rank', 'ASC');
        foreach ($this->db->get(self::$_plenaryLabelsTable)->result() as $row) {
            $labelIDs[] = $row->id;
        }

        if (!(count($labelIDs) > 0)) {
            return;
        }

        $objectiveIDs = array();
        $this->db->select('key_word');
        $this->db->where($this->_plenaryType, $this->_fkId);
        foreach ($this->db->get($this->_plenaryKeywordsTable)->result() as $row) {
            $objectiveIDs[] = $row->key_word;
        }

        if (!(count($objectiveIDs) > 0)) {
            return;
        }

        foreach ($labelIDs as $labelId) {
            foreach($objectiveIDs as $objectiveId) {
                $this->db->set('plenary_id', $plenaryId);
                $this->db->set('label_id', intval($labelId));
                $this->db->set('objective_id', intval($objectiveId));
                $this->db->insert(self::$_plenaryGridTable);
            }
        }
    }

    public function deletePlenary() {
        $this->db->delete(self::$_plenariesTable, array(
            'plenary_type' => $this->_plenaryType,
            'fk_id' => $this->_fkId
        ));

        return $this;
    }

    private function validConfiguration() {
        if ($this->_plenaryType !== 'module' && $this->_plenaryType !== 'lesson') {
            return FALSE;
        }

        if (!(intval($this->_fkId) > 0)) {
            return FALSE;
        }

        $this->db->select('id');
        $this->db->where('id', $this->_fkId);
        if (!($this->db->get($this->_plenaryForeignTable))) {
            return FALSE;
        }

        return TRUE;
    }

}
