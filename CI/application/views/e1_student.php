<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <h2>{lesson_title}</h2>
        <ul class="menu2">
            {items}
            <li idn="{item_type}{item_id}">
                <div class="main">
                    <div class="img">
                        <a href="/e5_student/index/{subject_id}/{module_id}/{lesson_id}/#/{item_order}"><img alt="" src="/img/icon_{item_iconindex}.png"></a>
                    </div>
                    <h4><a href="/e5_student/index/{subject_id}/{module_id}/{lesson_id}/#/{item_order}">{item_title}</a></h4>
                </div>
                <div class="info">
                    {resources_label}
                    <span class="glyphicon glyphicon glyphicon-list-alt"></span>
                    <span class="glyphicon glyphicon-facetime-video"></span>
                    <span class="glyphicon glyphicon-picture"></span>
                </div>
            </li>
            {/items}
        </ul>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            {view_interactive_lesson}
        </div>
    </div>
</footer>

