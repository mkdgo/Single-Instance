<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Imports extends MY_Controller {

	function __construct(){
		  parent::__construct();
                  
                  $this->load->model('admin_model');
                  
                  if($this->session->userdata('admin_logged')!=true)
                  {
                      redirect(base_url().'admin/login');
                  }
                  
                  
	}

	function index(){
            
           
                
                $this->_paste_admin(false,'admin/imports');
                
               
                
	}
        
        
        public function save_excel()
        {
            require_once(APPPATH.'libraries/phpexcel/PHPExcel.php');
            require_once(APPPATH.'libraries/phpexcel/PHPExcel/IOFactory.php');
		
                
               if($_POST && $_POST['save_excel'])
            {
            

                
	
        
        
	  $file_name = './uploads_excel/'.$_POST['file'];

	  
	  $objPHPExcel = PHPExcel_IOFactory::load($file_name);
	  $objWorksheet = $objPHPExcel->getActiveSheet();
	  $highestRow = $objWorksheet->getHighestRow();

          
        //Email/Password/First/Last/Email/Year
        
            if($objWorksheet->getCell('A1')->getValue()!='Email'&& $objWorksheet->getCell('B1')->getValue()!='Password'&& $objWorksheet->getCell('C1')->getValue()!='First'&& $objWorksheet->getCell('D1')->getValue()!='Last'&& $objWorksheet->getCell('F1')->getValue()!='Year')
            {
                $resp['error'] = 'Mismatched Fields: Email/Password/First/Last/Email/Year ';
            }
            else 
                {
                
                   //Get column to letter Z
              for($i='F';$i<'Z';++$i)
            {
                  if($objWorksheet->getCell($i.'1')->getValue()!='')
                  {
                $classes[].=trim($objWorksheet->getCell($i.'1')->getValue());
                $classes_letter[].=$i; 
                  }
            }
            
            
            $result_check =$this->admin_model->check_object($classes);
             if(!$result_check['result'])
                {
                    $resp['error'] = 'Mismatched subject '.$result_check['field'];
                
                    $resp['status'] = 'false';
                        echo json_encode($resp);
                        exit();
                }
                
                
                
                
            
            
            }
            
          
            
            //FIELDS PASSED Continue
            
            
            
            
            
            //$subjects = $this->admin_model->get_all_subjects(); --it retutrn all subjects //Math, English, LAtin etc.
            //map subjects
            
            
            //$classes letter examplle F G H
           foreach ($classes_letter as $class_lt)
            {
             for($i=2; $i<=$highestRow; $i++)
	  {
            
                 //$subject_name =  Math or English or Music Art etc
            $subject_name =  trim($objWorksheet->getCell($class_lt.'1')->getValue());    
                 if($objWorksheet->getCell($class_lt.$i)->getValue()!= '')
                 {
            $r[].= $objWorksheet->getCell($class_lt.$i)->getValue(); 
                 }
             }
             
             
             
             $unique_subj = array_filter(array_unique($r));
             
             $this->admin_model->map_subjects($subject_name,$unique_subj);
            
                
            }
           
           
            $msg ='';
           
	  for($i=2; $i<=$highestRow; $i++)
	  {
              
             
              
              $user_type = strtolower($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
              if(substr($user_type, 0,7)=='teacher')
              {
                $user['password'] = sha1($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                $user['first_name'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                $user['last_name'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                $user['email'] = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue().'@ediface.org';
                $user['student_year']=0;
                $user['user_type']= 'teacher';
                
                
                
                
              }
              else
              {
                  
            
                  
                  
                $user['password'] = sha1($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                $user['first_name'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                $user['last_name'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                $user['email'] = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue().'@ediface.org';
                $user['student_year']=trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue());
                $user['user_type']= 'student';
              }
              
             $user_data= $this->admin_model->check_imp_user($user);
             $msg[].=$user_data['msg'];
             
              //lets return user id and loop again to update student classes table
		if($user['user_type']== 'student')
                {
             foreach ($classes_letter as $class_lt)
            {
                $subject_name =  $objWorksheet->getCell($class_lt.'1')->getValue(); 
                $year_name =  $objWorksheet->getCell($class_lt.$i)->getValue();
                
                $this->admin_model->check_student_year_group($user_data['user_id'],$year_name,$subject_name);
                
              }
              
                }
             
                
                
                 
	  }
          $resp['import_results']= $msg;
          $resp['status'] = 'true';
	  echo json_encode($resp);
  

            }
         
              
        }
        
        
}



?>
