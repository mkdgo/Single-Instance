<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.fineuploader-3.5.0.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/fineuploader-3.5.0.css" type="text/css" />

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3>Add subject</b></h3>
                <br />
                <section class="tab-content" style="min-height: 300px;">
                    <div class="tab-pane active" id="static">
                        <div class="col-lg-8">
                            <form class="form-horizontal" action="<?php echo base_url() ?>admin/subjects/add" method="POST">
                                <?php echo validation_errors(); ?>
                                <div class="form-group">
                                    <label for="subject" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" placeholder="Subject name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <h5> Affected Years </h5>
                                        <?php foreach ($subject_years as $year): ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="year[]" value="<?php echo $year['year'] ?>"> Year <?php echo $year['year'] ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <h5> Published </h5>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="publish" value="1"> Publish
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
                                        <?php foreach ($subject_icons as $icon): ?>
                                            <div class="checkbox" style="float: left;">
                                                <label>
                                                    <input type="radio" name="icon" value="<?php echo $icon ?>"> <img src="<?php echo base_url() . 'uploads/subject_icons/' . $icon; ?>" title="<?php echo $icon ?>" />
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
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


<script type="text/javascript">
    var manualuploader = $('#manual-fine-uploader').fineUploader({
        request: {
            endpoint: base_url + 'admin/uploading/upload_subject_image'
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
    }).on('complete', function (event, id, file_name, responseJSON) {
        $('.loading').fadeIn(300);
        if (responseJSON.success) {
            var data = {
                file: responseJSON.file_name,
                save_excel: 'true'
            }
            window.location.reload();
        }
    });
</script>