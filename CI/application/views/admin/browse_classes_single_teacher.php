<script type="text/javascript" src="<?php echo base_url() ?>js/DataTables-1.10.7/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/DataTables-1.10.7/extensions/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
<link href="<?php echo base_url() ?>js/DataTables-1.10.7/media/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<link href="<?php echo base_url() ?>js/DataTables-1.10.7/extensions/FixedColumns/css/dataTables.fixedColumns.min.css" rel="stylesheet" media="screen">

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>Browse Teachers</h2>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">Teachers :: Browse :: <?php echo $this->_data['teacher_name']; ?></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Show Classes For
                                <select class="control" style="margin-left: 5px;" id="teacher_list">
                                    <option value="0">All Teachers</option>
                                    <?php foreach ($this->_data['all_teachers'] as $teacher): ?>
                                        <option value="<?php echo $teacher['id']; ?>" <?php if ($teacher['id'] == $this->_data['teacher_id']) echo 'selected="selected"'; ?>>
                                            <?php echo $teacher['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body texted-right">
                            <?php if (count($this->_data['subjects']) > 0): ?>
                                <table class="table" id="classes">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 120px; text-align: left;" class="has-filter">Teacher Name</th>
                                            <th style="min-width: 120px; text-align: left;" class="has-filter">Email Address</th>
                                            <?php foreach ($this->_data['subjects'] as $subject): ?>
                                                <th style="min-width: 120px; text-align: center;"><?php echo $subject; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($this->_data['teachers'] as $teacher): ?>
                                            <tr>
                                                <td style="min-width: 120px; text-align: left; white-space: nowrap;">
                                                    <?php echo $teacher['name']; ?>
                                                </td>
                                                <td style="min-width: 120px; text-align: left; white-space: nowrap;">
                                                    <?php echo $teacher['email']; ?>
                                                </td>
                                                <?php foreach ($teacher['subjects'] as $subject): ?>
                                                    <td style="min-width: 120px; text-align: center; white-space: nowrap;">
                                                        <?php foreach ($subject['classes'] as $class): ?>
                                                            Year: <?php echo $class['year']; ?>, Class: <?php echo $class['group_name']; ?><br />
                                                        <?php endforeach; ?>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="col-xs-12 text-left text-red">This teacher does not teach any subjects.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#teacher_list').change(function () {
            var teacher_id = $(this).val();
            if (parseInt(teacher_id, 10) > 0) {
                document.location = '<?php echo base_url('admin/browse_classes'); ?>/index/' + teacher_id;
            } else {
                document.location = '<?php echo base_url('admin/browse_classes'); ?>';
            }
        });

        <?php if (count($this->_data['subjects']) > 0): ?>
        var table = $('#classes').DataTable({
            "scrollX": "100%",
            "scrollCollapse": true,
            "bFilter" : false,               
            "bInfo" : false,               
            "bSort" : false,               
            "bPaginate" : false,               
            "bLengthChange": false
        });
        new $.fn.dataTable.FixedColumns(table);
        <?php endif; ?>
    });
</script>