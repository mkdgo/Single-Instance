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
                        <li class="active">Teachers :: Browse</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Browse Teachers</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body texted-right">
                            <table class="table" id="teachers">
                                <thead>
                                    <tr>
                                        <th style="min-width: 120px; text-align: left;" class="no-filter">Full Name</th>
                                        <th style="min-width: 45px; text-align: center;" class="no-filter">ID</th>
                                        <th style="min-width: 200px; text-align: left;" class="no-filter">Email Address</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach ($this->_data['teachers'] as $teacher): ?>
                                        <tr>
                                            <td style="min-width: 120px; text-align: left;"><?php echo $teacher['name']; ?></td>
                                            <td style="min-width: 45px; text-align: center;"><?php echo $teacher['id']; ?></td>
                                            <td style="min-width: 200px; text-align: left;"><?php echo $teacher['email']; ?></td>
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
        var table = $('#teachers').DataTable({
            "scrollX": "100%",
            "scrollCollapse": true,
            "oLanguage": {
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ teachers",
                "sLengthMenu": "Show _MENU_ teachers",
                "sSearch": "Search all columns for:"
            }
        });
        new $.fn.dataTable.FixedColumns(table);
    });
</script>