<?php

class Admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    
    /**
     * @access public
     * @param str $username (valid email)
     * @param str $password (SHA1)
     * @return BOOL(FALSE)/OR Admin data
     * @ 
     * 
     */
    public function login($username,$password)
    {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where(array('email'=>$username,'password'=>$password));
        $query = $this->db->get();
        if($query->num_rows()==1)
        {
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    
    
   /**
    * @access public
    * @return BOOL 
    */
   public function check_object($objects)
   {
       foreach ($objects as $obj)
       {
           
            $this->db->select('*');
            $this->db->from('subjects');
            $this->db->where('name',$obj);
            $query = $this->db->get();
            if($query->num_rows()==0)
            {
                return array('result'=>FALSE,'field'=>$obj);
            }
       }
       return array('result'=>TRUE);
   }


   //get all subjects
   public function get_all_subjects()
   {
       $this->db->select('id,name');
       $this->db->from('subjects');
       $this->db->where('name !=','');
       $query = $this->db->get();
      
       return $query->result_array();
   }

//check for existing class or create it 
   public function map_subjects($subject_name,$unique_subj)
   {
       
       foreach ($unique_subj as $subject)
       {
       
           $this->db->select('id');
           $this->db->from('subjects');
           $this->db->where('name',$subject_name);
           $q = $this->db->get();
           $s_id = $q->row();
           $subject_id = $s_id->id;
           
           
           
           
           $this->db->select('*');
           $this->db->from('classes');
           $group_name = substr($subject, -1);
           $year = substr($subject, 0, -1);
           
           
           //echo '{subject_id:'.$subject_id.' Year:'.$year.' - Group_name:'.strtolower($group_name).'}';
           
           
           $this->db->where(array('subject_id'=>$subject_id,'year'=>  $year,'group_name'=>  strtolower($group_name)));
          
           $query = $this->db->get();
           
           //echo $this->db->last_query().'{}';
           
             if($query->num_rows()==0)
             {
           $this->db->insert('classes',array('subject_id'=>$subject_id,'year'=>  $year,'group_name'=>  strtolower($group_name)));
             }
           
           
           
      // print_r($subject_name.'-'.$subject); 
       }
   }

   
   //import users in users column
    public function check_imp_user($user)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$user['email']);
        $query = $this->db->get();
        if($query->num_rows()==0)
        {
            $this->db->insert('users',$user);
            return array('user_id'=>$this->db->insert_id(),'msg'=>$user['email'].'- Inserted');
        }
        else
        {
            $result = $query->row_array();
            $this->db->where('id',$result['id']);
            $this->db->update('users',$user);
            return array('user_id'=>$result['id'],'msg'=>$user['email'].'- Updated');
            
        }
    }
    
    
    public function check_student_year_group($user_id,$year_name,$subject_name)
    {
        //first get subject id from subjects
        $this->db->select('id');
        $this->db->from('subjects');
        $this->db->where('name',$subject_name);
        $qt = $this->db->get();
        $s_id = $qt->row();
        $subject_id = $s_id->id;
        
        
           $this->db->select('id');
           $this->db->from('classes');
           $group_name = substr($year_name, -1);
           $year = substr($year_name, 0, -1);
           $this->db->where(array('subject_id'=>$subject_id,'year'=>  $year,'group_name'=>  strtolower($group_name)));
           $query = $this->db->get();
           $res = $query->row();
             if($query->num_rows()==1)
             {
                 
                 $class_id = $res->id;
                 $this->db->select('*');
                 $this->db->from('student_classes');
                 $this->db->where(array('student_id'=>$user_id,'class_id'=>$class_id));
                 $q = $this->db->get();
                 if($q->num_rows()==0)
                 {
                 $this->db->insert('student_classes',array('student_id'=>$user_id,'class_id'=>$class_id));
                 }
                 
                 
             }
    }
    
    
    
    
    
}
?>
