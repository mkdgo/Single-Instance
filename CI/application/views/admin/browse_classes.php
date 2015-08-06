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
                        <li class="active">Teachers :: Browse :: All Teachers</li>
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
                                    <?php foreach ($this->_data['teachers'] as $teacher): ?>
                                    <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body texted-right">
                            <table class="table" id="classes">
                                <thead>
                                    <tr>
                                        <th style="min-width: 120px; text-align: left;" class="has-filter">Teacher Name</th>
                                        <th style="min-width: 120px; text-align: left;">Email Address</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#teacher_list').change(function() {
            var teacher_id = $(this).val();
            if (parseInt(teacher_id, 10) > 0) {
                document.location = '<?php echo base_url('admin/browse_classes'); ?>/index/' + teacher_id;
            }
        });
        
        var table = $('#classes').DataTable({
            "scrollX": "100%",
            "scrollCollapse": true,
            "oLanguage": {
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ teachers",
                "sLengthMenu": "Show _MENU_ teachers",
                "sSearch": "Search all columns for:"
            },
            initComplete: function () {
                this.api().columns('.has-filter').every(function () {
                    var column = this;
                    var select = $('<br><select class="disable-sort"><option value=""></option></select>')
                            .appendTo($(column.header()))
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });

                $('th .disable-sort').click(function (event) {
                    event.stopPropagation();
                });
            }
        });
        new $.fn.dataTable.FixedColumns(table);
    });
</script>