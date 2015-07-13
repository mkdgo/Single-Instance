<script type="text/javascript" src="<?php echo base_url() ?>js/DataTables-1.10.7/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/DataTables-1.10.7/extensions/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
<link href="<?php echo base_url() ?>js/DataTables-1.10.7/media/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
<link href="<?php echo base_url() ?>js/DataTables-1.10.7/extensions/FixedColumns/css/dataTables.fixedColumns.min.css" rel="stylesheet" media="screen">

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>Browse Students</h2>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">Students :: Browse</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Browse Students</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body texted-right">
                            <table class="table" id="students">
                                <thead>
                                    <tr>
                                        <th style="min-width: 120px; text-align: left;" class="no-filter">Full Name</th>
                                        <th style="min-width: 45px; text-align: center;" class="no-filter">ID</th>
                                        <th style="min-width: 200px; text-align: left;" class="no-filter">Email Address</th>
                                        <th style="min-width: 25px; text-align: center;" class="has-filter">Year</th>
                                        <?php foreach ($this->_data['subjects'] as $subject): ?>
                                            <th style="min-width: 120px; text-align: center;" class="has-filter"><?php echo $subject; ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach ($this->_data['students'] as $student): ?>
                                        <tr>
                                            <td style="min-width: 120px; text-align: left;"><?php echo $student['name']; ?></td>
                                            <td style="min-width: 45px; text-align: center;"><?php echo $student['id']; ?></td>
                                            <td style="min-width: 200px; text-align: left;"><?php echo $student['email']; ?></td>
                                            <td style="min-width: 25px; text-align: center;"><?php echo $student['year']; ?></td>
                                            <?php foreach ($student['classes'] as $class): ?>
                                                <td style="min-width: 120px; text-align: center;"><?php echo $class['class_name']; ?></td>
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
        var table = $('#students').DataTable({
            "scrollX": "100%",
            "scrollCollapse": true,
            "oLanguage": {
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ students",
                "sLengthMenu": "Show _MENU_ students",
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
        
        $('#students').on('search.dt', function() {
            console.log('searching...');
        });
    });
</script>