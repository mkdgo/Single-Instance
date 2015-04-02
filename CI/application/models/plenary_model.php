<?php

class Plenary_model extends CI_Model {

    private static $_plenariesTable = 'plenaries';
    private static $_plenaryResultsTable = 'plenary_results';
    private static $_plenaryGridTable = 'plenary_grid';
    private static $_plenaryLabelsTable = 'plenary_grade_labels';
    private static $_contentPagePlenariesTable = 'content_page_plenaries';
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

    public function contentPagePlenaryExists($content_page_id, $plenary_id) {
        $this->db->where('cont_page_id', intval($content_page_id));
        $this->db->where('plenary_id', intval($plenary_id));

        return (count($this->db->get(self::$_contentPagePlenariesTable)->result()) > 0);
    }

    public function getContentPagePlenaries($content_page_id) {
        $this->db->select('cpp.*, pl.plenary_type, pl.fk_id');
        $this->db->from(self::$_contentPagePlenariesTable . ' cpp');
        $this->db->where('cpp.cont_page_id', $content_page_id);
        $this->db->join(self::$_plenariesTable . ' pl', 'pl.id = cpp.plenary_id');

        return $this->db->get()->result();
    }

    public function getPlenaryGrid($plenary_id) {
        $this->db->select('pg.id, pg.objective_id, kwo.word AS objective, pg.label_id, pgl.label, pgl.label_rank');
        $this->db->from(self::$_plenaryGridTable . ' pg');
        $this->db->join('key_words_objectives kwo', 'kwo.id = pg.objective_id');
        $this->db->join('plenary_grade_labels pgl', 'pgl.id = pg.label_id');
        $this->db->where('pg.plenary_id', $plenary_id);
        $this->db->order_by('pg.objective_id', 'ASC');
        $this->db->order_by('pgl.label_rank', 'ASC');

        return $this->db->get()->result();
    }

    public function insertContentPagePlenary($content_page_id, $plenary_id) {
        $this->db->set('cont_page_id', $content_page_id);
        $this->db->set('plenary_id', $plenary_id);
        $this->db->insert(self::$_contentPagePlenariesTable);
    }

    public function deleteContentPagePlenary($content_page_id) {
        $this->db->delete(self::$_contentPagePlenariesTable, array(
            'cont_page_id' => $content_page_id
        ));
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
            foreach ($objectiveIDs as $objectiveId) {
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

    public function getPlenariesAsResources($moduleId, $lessonId) {
        $sql = 'SELECT id, plenary_type FROM plenaries WHERE (plenary_type = ? AND fk_id = ?) OR (plenary_type = ? AND fk_id = ?)';
        return $this->db->query($sql, array('module', $moduleId, 'lesson', $lessonId))->result();
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

    public function deletePlenaryResults($subject_id, $module_id, $lesson_id, $student_id, $content_page_id) {
        $this->db->delete(self::$_plenaryResultsTable, array(
            'subject_id' => $subject_id,
            'module_id' => $module_id,
            'lesson_id' => $lesson_id,
            'content_page_id' => $content_page_id,
            'user_id' => $student_id
        ));
    }

    public function insertPlenaryResult($subject_id, $module_id, $lesson_id, $student_id, $content_page_id, $objective_id, $value_id) {
        $this->db->set('subject_id', $subject_id);
        $this->db->set('module_id', $module_id);
        $this->db->set('lesson_id', $lesson_id);
        $this->db->set('content_page_id', $content_page_id);
        $this->db->set('user_id', $student_id);
        $this->db->set('objective_id', $objective_id);
        $this->db->set('value_id', $value_id);
        $this->db->insert(self::$_plenaryResultsTable);
    }

    public function plenaryResultExists($subject_id, $module_id, $lesson_id, $student_id, $content_page_id, $objective_id, $value_id) {
        $this->db->where('subject_id', $subject_id);
        $this->db->where('module_id', $module_id);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('content_page_id', $content_page_id);
        $this->db->where('user_id', $student_id);
        $this->db->where('objective_id', $objective_id);
        $this->db->where('value_id', $value_id);

        return (count($this->db->get(self::$_plenaryResultsTable)->result()) > 0);
    }

    public function getOverallPlenaryResults($subject_id, $module_id, $lesson_id, $content_page_id) {
        $this->db->where('subject_id', $subject_id);
        $this->db->where('module_id', $module_id);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('content_page_id', $content_page_id);

        return $this->db->get(self::$_plenaryResultsTable)->result_array();
    }
}
