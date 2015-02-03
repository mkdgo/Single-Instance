<script type="text/javascript" src="<?php echo base_url()?>js/jquery.fineuploader-3.5.0.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/fineuploader-3.5.0.css" type="text/css" />

<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="javascript:;">
                       Welcome Admin
                    </a>
                     
                </li>
                <li>
                    <a href="<?php echo base_url('admin/dashboard')?>">Dashboard</a>
                </li>
                
                <li>
                    <a href="<?php echo base_url('admin/imports')?>">Imports</a>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/subjects')?>">Subjects</a>
                </li>
               
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="icon-home">< Menu ></i></a>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        
                        <h3><b>Edit subject <?php echo $single_subject['name'];?></b></h3>
                        <br />
                        <section class="tab-content" style="min-height: 300px;">
                            
                                    <!-- Tab #static -->
                                    <div class="tab-pane active" id="static">
                       
                                        <div class="col-lg-8">
                                        
                                        
                                            
                                            
 <form class="form-horizontal" action="<?php echo base_url()?>admin/subjects/edit_subject/<?php echo $subject_id;?>" method="POST">
     <?php echo validation_errors(); ?>
     
  <div class="form-group">
    <label for="subject" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Subject name" value="<?php echo $single_subject['name']?>">
    </div>
  </div>
 
    
  <div class="form-group">
     
    <div class="col-sm-offset-2 col-sm-10">
    <h5> Affected Years </h5>
  <?php //$years = @explode(',', $subject_years_name['rst']);
  $checked_years = @explode(',', $published_subject_years['rst']);
  ?>
        <?php
        
        
        foreach($all_subject_years as $year):
            
         ?>
        
        
        
      <div class="checkbox">
        <label>
            <input type="checkbox" name="year[]" value="<?php echo $year['year']?>" <?php if(in_array($year['year'], $checked_years)){echo 'checked="checked"';}?> > Year <?php echo $year['year']?> 
        </label>
      </div>
        
       
        <?php 
        
        endforeach;?>
    </div>
  </div>
     
     <div class="form-group">
     
    <div class="col-sm-offset-2 col-sm-10">
    <h5> Published </h5>
  
        
        
      <div class="checkbox">
        <label>
            <input type="checkbox" name="publish" value="1" <?php if($single_subject['publish']==1){echo 'checked="checked"';}?> > Publish
          
        </label>
      </div>
        
        
      
    </div>
  </div>
      <div class="form-group">
     
    <div class="col-sm-offset-2 col-lg-12">
    <h5> Select icon  OR add new icon</h5>
    
    <div class="loading"></div>

                                        <div id="manual-fine-uploader" class="btn btn-danger" style="padding:0 10px;height: 22px;margin-top:10px;"></div>
                                        <div id="triggerUpload"  style="margin-top: 20px;">
                                            
                                         <small>*Only png images(width:147px,height:147px)</small>   
                                        </div>
                                        


                                        
  
        
        <?php foreach ($subject_icons as $icon):?>
    <div class="checkbox" style="float: left;">
        <label>
            <input type="radio" name="icon" value="<?php echo $icon?>" <?php if($single_subject['logo_pic']==$icon){
                echo 'checked="checked"';}?>> <img src="<?php echo base_url().'uploads/subject_icons/'.$icon;?>"  title="<?php echo $icon?>" />
          
        </label>
      </div>
    
        <?php endforeach;?>
        
      
    </div>
  </div>
     
     
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary" name="submit" value="true">Save</button>
    </div>
  </div>
</form>
                                        
                                        </div>
                                        
                                     


                                    </div>
                                    <!-- /Tab #static -->

                                    <div class="modal hide fade" id="confirm-modal">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">x</button>
                                                <h3>Please confirm</h3>
                                            </div>
                                            <div class="modal-body">
                                                Description...
                                            </div>
                                            <div class="modal-footer"></div>
                                        </div>	

                                </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    
     <script type="text/javascript">
    
        var manualuploader = $('#manual-fine-uploader').fineUploader({
            request: {
                endpoint: base_url+'admin/uploading/upload_subject_image'
            },
            multiple: false,
            validation: {
                allowedExtensions: ['png'],
                sizeLimit: 9120000, // 9000 kB -- 9mb max size of each file
                itemLimit: 40
            },
            autoUpload: true,
            text: {
                uploadButton: 'Select logo image'
            }
        }).on('complete', function(event, id, file_name, responseJSON) {
            
        $('.loading').fadeIn(300);
            //console.log(responseJSON);
            if (responseJSON.success) {

                var data = {
                    file: responseJSON.file_name,
                    save_excel: 'true'
                }
               window.location.reload();


            }
        })

   
    
    </script>
    