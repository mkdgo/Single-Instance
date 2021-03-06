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
            <a href="<?php echo base_url('admin/users/browse_students') ?>" class="li-browse-students">Browse Students</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/browse_classes') ?>" class="li-browse-classes">Browse Teachers</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/imports') ?>" class="li-imports">Imports</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/subjects') ?>" class="li-subjects">Subjects</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/settings') ?>" class="li-settings">Site Settings</a>
        </li>
        <li>
            <a href="<?php echo base_url('admin/elastic') ?>" class="li-elastic">Elastic</a>
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
        } else if (tpl.indexOf('browse_students') !== -1) {
            $('.li-browse-students').addClass('active');
        } else if (tpl.indexOf('browse_classes') !== -1) {
            $('.li-browse-classes').addClass('active');
        } else if (tpl.indexOf('imports') !== -1) {
            $('.li-imports').addClass('active');
        } else if (tpl.indexOf('subjects') !== -1) {
            $('.li-subjects').addClass('active');
        } else if (tpl.indexOf('settings') !== -1) {
            $('.li-settings').addClass('active');
        } else if (tpl.indexOf('elastic') !== -1) {
            $('.li-elastic').addClass('active');
        }
    });
</script>