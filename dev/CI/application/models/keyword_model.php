<?php
class Keyword_model extends CI_Model {
   
        
        public function suggestKeywords($kwq)
        {
            $this->db->from('key_words');
            $this->db->where('word LIKE "'.$kwq.'%" AND word != "'.$kwq.'"');
            $query = $this->db->get();
            
            return $query->result();
        }
        
        public function getResourceKeyword($rid)
        {
            $this->db->from('key_words');
            $this->db->join('key_words_resources', 'key_words.id = key_words_resources.key_word');
            $this->db->where('key_words_resources.resource', $rid);
            $query = $this->db->get();

            return $query->result();
        }
        
        
        
        public function updateResourceKeywords($kws, $rid)
        {
            
            
            $existing_words = array();
            $existing_ids = array();
            $new_words = array();
            $new_ids = array();
            
            $this->db->from('key_words');
            $this->db->where('word IN ("'.implode('","',$kws).'")');
            $query = $this->db->get();
            $existing_w = $query->result();
            
            foreach($existing_w as $kw => $vw)
            {
                $existing_words[]=$vw->word;
                $existing_ids[$vw->word]=$vw->id;
            }
            
            $new_words = array_diff($kws, $existing_words);
            foreach($new_words as $kw => $vw)
            {
                 $this->db->insert('key_words', array('word'=>$vw) );
                 $id = $this->db->insert_id();
                 $new_ids[$vw]=$id;
            }
            
            $all_relations = array_merge($new_ids, $existing_ids);
            
            $this->db->delete('key_words_resources', array('resource' => $rid)); 
            
            foreach($all_relations as $kw => $vw)
            {
                $this->db->insert('key_words_resources', array('key_word'=>$vw, 'resource'=>$rid) );
            }
           
        }
        
		
}