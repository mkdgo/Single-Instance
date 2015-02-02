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
    
    /* SUBJECTS */
    
    //get all subjects
   public function get_all_subjects()
   {
       $this->db->select('id,name');
       $this->db->from('subjects');
       $this->db->where('name !=','');
       $query = $this->db->get();
      
       return $query->result_array();
   }
    
    public function get_subject_by_id($id) {
        
        $this->db->select('*');
        $this->db->from('subjects');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
		
		
	}
    
    public function get_subject_years($subject_id) {
            
        $query = $this->db->order_by("year", "asc")->get_where('subject_years', array('subject_id' => $subject_id));
        return $query->result_array();
	}
        
        public function get_subject_years_name($subject_id) {
            
            $q = "SELECT GROUP_CONCAT(year SEPARATOR ', ') as rst FROM subject_years WHERE subject_id='$subject_id'";
            
           $result= $this->db->query($q);
            
           return $result->row_array();
           
//            $this->db->select('year');
//            $this->db->from('subject_years');
//            $this->db->where('subject_id',$subject_id);
//            
//            $query = $this->db->get();
//            
//           
//            return $query->result_array();
	}
        
        public function get_all_subject_years()
        {
            $this->db->select('year');
            $this->db->from('subject_years');
            $this->db->group_by('year');
            $query = $this->db->get();
            
           
            return $query->result_array();
            
        }
        
        
        public function get_published_subject_years($subject_id)
        {
            
        $q = "SELECT GROUP_CONCAT(year SEPARATOR ', ') as rst FROM subject_years WHERE subject_id='$subject_id' AND publish=1";
        $query = $this->db->query($q);
//            $this->db->select('year');
//            $this->db->from('subject_years');
//            $this->db->where(array('subject_id'=>$id,'publish'=>1));
//            $query = $this->db->get();
            
           
            return $query->row_array(); 
        }
        
        
        public function add_subject($data)
        {
            
             
            if($data['publish']==false)
            {
                $publish = 0;
            }
            else
            {
                $publish = 1;
            }
            
            $this->db->insert('subjects',array('name'=>$data['name'],'publish'=>$publish,'logo_pic'=>$data['icon']));
            
            return $this->db->insert_id();
            
            
            
        }
        
        
        
        public function update_subject($id,$data)
        {
            
            
            if($data['publish']==false)
            {
                $publish = 0;
            }
            else
            {
                $publish = 1;
            }
            $this->db->where('id',$id);
            $this->db->update('subjects',array('name'=>$data['name'],'publish'=>$publish,'logo_pic'=>$data['icon']));
            
            return TRUE;
        }

        public function update_subject_years($years,$subject_id)
        {
            
            $this->db->where(array('subject_id'=>$subject_id));
            $this->db->update('subject_years',array('publish'=>0));
            
            foreach ($years as $y)
            {
            $this->db->select('*');
            $this->db->from('subject_years');
            $this->db->where(array('subject_id'=>$subject_id,'year'=>$y['year']));
            
            $q= $this->db->get();
            
            if ($q->num_rows()==0)
            {
             $this->db->insert('subject_years',array('subject_id'=>$subject_id,'year'=>$y['year'],'publish'=>1)); 
            }
            else if($q->num_rows()==1)
            {
               $this->db->where(array('subject_id'=>$subject_id,'year'=>$y['year']));
               $this->db->update('subject_years',array('publish'=>1)); 
            }
            
            
            }
            
//            return true;
//            
////            $this->db->select('id,year_id');
////            $this->db->from('modules');
////            $this->db->where('subject_id',$subject_id);
////            $q= $this->db->get();
//////            
////            $res= $q->result_array();
////            
////            foreach ($res as $k=>$v)
////            {
////                $arr['d'][$k]=$v;
////            }
//            
//            
//            
//            
////            echo '<pre>';
////            
////            print_r($arr);
////            
////            echo '</pre>';
////            die();
//            
//           // $this->db->where('subject_id',$subject_id);
//           // $this->db->delete('subject_years');
//            foreach ($years as $y)
//            {
//              $this->db->insert('subject_years',array('subject_id'=>$subject_id,'year'=>$y['year']));
//                
//             // $insert_id = $this->db->insert_id();
//              
//                //$this->db->where('subject_id',$subject_id);
//               // $this->db->update('modules',array('year_id'=>$insert_id));
//            }
//            
//            
//            $this->db->select('*');
//            $this->db->from('subject_years');
//            $this->db->where('subject_id',$subject_id);
//            $this->db->order_by('year,id','asc');
//            
//            $query = $this->db->get();
//            
//           // die($this->db->last_query());
//            
//            $res = $query->result_array();
//            
//            $num_rows = $query->num_rows();
//            
//            
//           // print_r($res[0]);
//            $delete = array();
//            
//            for($i=0;$i<$num_rows;$i++)
//            {
//                if($i==$num_rows-1)
//                    break;
//                                      
//                
//                $current = $res[$i];
//                
//                $next = $res[$i+1];
//                //echo 'current year: ' . $current['year'] . '<br>';
//               //echo 'next year: ' . $next['year'] . '<br>';
//                if ($current['year'] == $next['year']) {
//                    //echo $current['id'] . '<br>';
//                    $delete[] = $current['id'];
//                    //var_dump($delete);
//                  $this->db->query('update modules set year_id = '.$next["id"].' where subject_id = '.$subject_id.' AND year_id = '.$current["id"].'');
//                }
//                
//                
//                
//                
//            }
//           print_r($delete);
//            if (count($delete) > 0) {
//                $this->db->query('delete  from subject_years where id in ('.implode(',', $delete).')');
//            }
//           
//            
//           // $this->db->where()
//            
////            
////            
//          
            
            
            
            
            
            
            
            
            
            
            
            
            
            //update curriculum table
            
             foreach ($years as $y)
            {
            $this->db->select('*');
            $this->db->from('curriculum');
            $this->db->where(array('subject_id'=>$subject_id,'year_id'=>$y['year']));
            $query = $this->db->get();
            
            if($query->num_rows()==0)
            {
                $this->db->insert('curriculum',array('subject_id'=>$subject_id,'year_id'=>$y['year']));
            }
            
            }
            
            $this->db->select('*');
            $this->db->from('curriculum');
            $this->db->where(array('subject_id'=>$subject_id,'year_id'=>0));
            $query = $this->db->get();
            
            if($query->num_rows()==0)
            {
                $this->db->insert('curriculum',array('subject_id'=>$subject_id,'year_id'=>0));
            }
            
            
            
            
            
            return TRUE;
        }

        /*END SUBJECTS */
    
    
    
    
}
?>
