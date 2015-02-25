<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12"><a href="<?php echo base_url() . 'admin/subjects/add' ?>" style="float: right;"><button class="btn btn-danger">Add new Subject</button></a></div>
                <h2>View subject <b><?php echo $single_subject['name'] ?></b></h2>
                <section class="tab-content" style="min-height: 300px;">
                    <div class="tab-pane active" id="static">
                        <?php
                        echo '<ul>';
                        foreach ($subject_years as $sub) {
                            ?>
                            <li class="list-group-item"><?php echo $sub['year'] ?> <a href="<?php echo base_url() . 'admin/subjects/edit_curriculum/' . $sub['subject_id'] . '/' . $sub['year'] ?>" class="btn btn-small"><i class="icon-edit">Edit curriculum</i></a></li>
                            <?php
                        }
                        echo '<ul>';
                        ?>
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
                </section>
            </div>
        </div>
    </div>
</div>