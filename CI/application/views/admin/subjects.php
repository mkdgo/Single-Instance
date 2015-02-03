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
                        <div class="col-lg-12"><a href="<?php echo base_url().'admin/subjects/add'?>" style="float: right;"><button class="btn btn-danger">Add new Subject</button></a>
 </div>
                        <h2>List subjects</h2>
                        <section class="tab-content" style="min-height: 300px;">
                            
                                    <!-- Tab #static -->
                                    <div class="tab-pane active" id="static">
                       

                                       
                                        <?php 
                                        
                                       
                                            echo '<ul>';
                                        
                                            foreach ($subjects as $sub)
                                            {?>
                                        
                                        <li class="list-group-item"><?php echo $sub['name']?> 
                                        <a href="<?php echo base_url().'admin/subjects/view/'.$sub['id']?>" class="btn btn-small"><i class="icon-edit">View</i></a>
                                        <a href="<?php echo base_url().'admin/subjects/edit_subject/'.$sub['id']?>" class="btn btn-small"><i class="icon-edit">Edit</i></a>
                                        </li>
                                            
                                        
                                      
                                       
                                            <?php }
                                         echo '<ul>';
                                        
                                        
                                        ?>


                                        


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