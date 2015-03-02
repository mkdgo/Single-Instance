<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="javascript:;">
                Welcome Admin
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/dashboard') ?>" class="li-dashboard">Dashboard</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/users') ?>" class="li-user-mgmt">User Management</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/imports') ?>" class="li-imports">Imports</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/subjects') ?>" class="li-subjects">Subjects</a>
        </li>
    </ul>
</div>
<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="icon-home">< Menu ></i></a>
<div class="ajax-processing"></div>
<script type="text/javascript">
    $(document).ready(function() {
        var tpl = '{template}';
        if (tpl.indexOf('dashboard') !== -1) {
            $('.li-dashboard').addClass('active');
        } else if (tpl.indexOf('users') !== -1) {
            $('.li-user-mgmt').addClass('active');
        } else if (tpl.indexOf('imports') !== -1) {
            $('.li-imports').addClass('active');
        } else if (tpl.indexOf('subjects') !== -1) {
            $('.li-subjects').addClass('active');
        }
    });
</script>