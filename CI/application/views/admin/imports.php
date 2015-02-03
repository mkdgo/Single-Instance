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
                        <h2>Import users</h2>
                        <section class="tab-content" style="min-height: 300px;">

                                    <!-- Tab #static -->
                                    <div class="tab-pane active" id="static">


                                        <div class="loading"></div>

                                        <div id="manual-fine-uploader" class="btn btn-default" style="padding:0 10px;height: 22px;margin-top:10px;"></div>
                                        <div id="triggerUpload"  style="margin-top: 20px;"></div>


                                        <div class="result" style="width: 100%; margin-top: 60px;border: 1px dashed #ccc;float: left;">

                                        </div> 




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


                                    </div>
                                    <!-- /Tab #static -->



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
                endpoint: base_url+'admin/uploading/upload_excel'
            },
            multiple: false,
            validation: {
                allowedExtensions: ['xls|xlsx|csv'],
                sizeLimit: 9120000, // 9000 kB -- 9mb max size of each file
                itemLimit: 40
            },
            autoUpload: true,
            text: {
                uploadButton: 'Upload excel users'
            }
        }).on('complete', function(event, id, file_name, responseJSON) {
            
        $('.loading').fadeIn(300);
            //console.log(responseJSON);
            if (responseJSON.success) {

                var data = {
                    file: responseJSON.file_name,
                    save_excel: 'true'
                }
                $.ajax({
                    type: "POST",
                    url: base_url+"admin/imports/save_excel",
                    data: data,
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status == 'true')
                        {

                            //console.log(resp);

                            var rr = resp.import_results;
                           
                            $.each(rr, function(i, item) {
                                $('.result').append('<p>' + item + '</p>');
                                console.log(item);
                            });
                            
                             $('.loading').fadeOut(300);
                            //alert(data[i].PageName);






                            //$('.result').html(resp.re);
                            //alert(resp.re)
                        }
                        else if(resp.status == 'false')
                        {
                        $('.result').append('<p class="error_result"><b>' + resp.error + '</b></p>');
                         $('.loading').fadeOut(300);
                        }
                        
                        
                        

                    }

                });


            }
        })

   
    
    </script>