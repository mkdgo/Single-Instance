<div class="blue_gradient_bg">
	<div class="breadcrumb_container">
		<div class="container">
		    <ul class="breadcrumb">
              <li>Search </li>
              <li class="active">{query}</li>
            </ul>
	    </div>
	</div>
<!--resources: {resources_count}
    modules: {modules_count} -->
	<div class="container">
    <div class='universal_search' style="margin-left: -10px;" >

        <span style="margin-left: 20px;" class="lesson_title"><?php if(!$modules && !$lessons && !$resources && !$users){echo 'No results found for this search';} else {echo 'Results';}?> </span>

        <div id="all_resources">
            <!-- <div class='returned_results'>{results}</div> -->

            <ul class="nav nav-pills " role="tablist">
                <li role="presentation" class="active" ><a href="#all_tabs" aria-controls="all_tab" role="tab" data-toggle="tab">All</a></li>
                <li role="presentation" ><a href="#modules_tab" aria-controls="modules_tab" role="tab" data-toggle="tab">Modules ({modules_count})</a></li>
                <li role="presentation" ><a href="#lessons_tab" aria-controls="lessons_tab" role="tab" data-toggle="tab">Lessons ({lessons_count})</a></li>
                <li role="presentation" ><a href="#resources_tab" aria-controls="resources_tab" role="tab" data-toggle="tab">Resources ({resources_count})</a></li>
                <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                <li role="presentation" ><a href="#students_tab" aria-controls="students_tab" role="tab" data-toggle="tab">Students ({users_count})</a></li>
                <?php endif; ?>
                <li role="presentation" ><a href="#works_tab" aria-controls="works_tab" role="tab" data-toggle="tab">Work (0)</a></li>
            </ul>


            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="all_tabs">


                    {if modules}
                    <h3>Modules</h3>
                    <table>
                        <tr>
                            <th width="10%">Type</th>
                            <th>Name</th>
                            <th width="10%">Subject</th>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <!-- <th width="10%">Year</th> -->
                                <th width="5%">Edit</th>
                            <?php endif ?>
                        </tr>
                        <?php foreach ($modules as $module){?>

                        <tr>
                            <td class="resource_cell name-resource"><?php echo $module['type']?></td>
                            <!--                    <td class="resource_cell resource_icon"><span class="icon" style="background-image: url('/uploads/subject_icons/{subject_logo}');background-size: cover;  -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover; width: 24px; height: 24px; " title="{subject_title}"></span></td>-->
                            <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?><a  href="/d4_teacher/index/<?php echo $module['subject_id']?>/<?php echo $module['module_id']?>"><?php echo $module['name']?></a><?php } else {?><a  href="/d4_student/index/<?php echo $module['subject_id']?>/<?php echo $module['module_id']?>"><?php echo $module['name']?></a> <?php }?></td>
                            <td class="resource_cell name-resource"><?php echo $module['subject_title']?></td>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <!-- <td class="resource_cell name-resource">{year}</td>-->
                                <td><a class='edit' href="/d4_teacher/index/1/<?php echo $module['module_id']?>"></a></td>
                            <?php endif ?>
                        </tr>
                        <?php }?>
                    </table>
                    {/if}


                    {if lessons}
                    <h3>Lessons</h3>
                    <table>
                        <tr>
                            <th width="10%">Type</th>
                            <th>Name</th>
                            <th width="10%">Subject</th>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <!-- <th width="10%">Year</th> -->
                                <th width="5%">Edit</th>
                            <?php endif ?>
                        </tr>
                        {lessons}
                        <tr>
                            <td class="resource_cell name-resource">{type}</td>
                            <!--                    <td class="resource_cell resource_icon"><span class="icon" style="background-image: url('/uploads/subject_icons/{subject_logo}');background-size: cover;  -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover; width: 24px; height: 24px; " title="{subject_title}"></span></td>-->
                            <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?><a  href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">{title}</a><?php }else {?><a  href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">{title}</a> <?php } ?></td>
                            <td class="resource_cell name-resource">{subject_title}</td>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <!--<td class="resource_cell name-resource">{year}</td>-->
                                <td><a class='edit' href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}"></a></td>
                            <?php endif ?>
                        </tr>
                        {/lessons}
                    </table>
                    {/if}


                    {if resources}
                    <h3>Resources</h3>
                    <table class='table3' style="border-top: none;">
                        <tr style="border-top: none;">
                            <th width="10%">Type</th>
                            <th>Name</th>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <th width="10%">Added By</th>
                                <!--<th width="10%">Date Added</th>-->
                                <th width="5%">Edit</th>
                            <?php endif ?>
                        </tr>
                        {resources}
                        <tr>
                            <td class="resource_cell resource_icon"><span title="{type_title}" class="icon {type}"></span></td>
                            <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?> <a href="/c2/index/resource/{resource_id}">{title}</a><?php }else{?>{title}<?php }?></td>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <td class='resource_cell preview-resource'>{user}</td>
                                <!--<td class="resource_cell name-resource">{date_added}</td>-->
                                <td><?php if($this->session->userdata('user_type') == 'teacher'){?>   <a class='edit' href="/c2/index/resource/{resource_id}"></a><?php }?></td>
                            <?php endif ?>
                        </tr>
                        {/resources}
                    </table>
                    {/if}


                    <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                        {if users}
                        <h3>Students</h3>
                        <table>
                            <tr>
                                <th width="5%">Year</th>
                                <th>Name</th>
                                <th width="10%">Type</th>
                                <th width="5%"><?php if($this->session->userdata('user_type') == 'teacher'){ echo '';/* 'Edit';*/ }?></th>
                            </tr>
                            {users}
                            <tr>
                                <td class="resource_cell resource_icon"><span class="icon" style="background-image: url('/img/{year}.png');background-size: cover;  -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover; width: 24px; height: 24px; " title="{year}"></span></td>
                                <td class="resource_cell name-resource"><a href="/g2/index/{id}">{name}</a></td>
                                <td class="resource_cell name-resource">{type}</td>
                                <td><?php if($this->session->userdata('user_type') == false /*'teacher'*/ ) { ?><a class='edit' data-href="/u1/user/{id}"></a><?php }?></td>
                            </tr>
                            {/users}
                        </table>
                        {/if}
                    <?php endif ?>


                        <h3>Work</h3>
                    
                </div>


                <div role="tabpanel" class="tab-pane fade" id="modules_tab">
                    {if modules}
                    <h3>Modules</h3>
                    <table>
                        <tr>
                            <th width="10%">Type</th>
                            <th>Name</th>
                            <th width="10%">Subject</th>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                               <!-- <th width="10%">Year</th> -->
                                <th width="5%">Edit</th>
                            <?php endif ?>
                        </tr>
                        {modules}
                        <tr>
                            <td class="resource_cell name-resource">{type}</td>
                            <!--                    <td class="resource_cell resource_icon"><span class="icon" style="background-image: url('/uploads/subject_icons/{subject_logo}');background-size: cover;  -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover; width: 24px; height: 24px; " title="{subject_title}"></span></td>-->
                            <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?><a  href="/d4_teacher/index/{subject_id}/{module_id}">{name}</a><?php } else {?><a  href="/d4_student/index/{subject_id}/{module_id}">{name}</a> <?php }?></td>
                            <td class="resource_cell name-resource">{subject_title}</td>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                               <!-- <td class="resource_cell name-resource">{year}</td>-->
                                <td><a class='edit' href="/d4_teacher/index/1/{module_id}"></a></td>
                            <?php endif ?>
                        </tr>
                        {/modules}
                    </table>
                    {/if}
                </div>
                <div role="tabpanel" class="tab-pane fade" id="lessons_tab">
                    {if lessons}
                    <h3>Lessons</h3>
                    <table>
                        <tr>
                            <th width="10%">Type</th>
                            <th>Name</th>
                            <th width="10%">Subject</th>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                               <!-- <th width="10%">Year</th> -->
                                <th width="5%">Edit</th>
                            <?php endif ?>
                        </tr>
                        {lessons}
                        <tr>
                            <td class="resource_cell name-resource">{type}</td>
                            <!--                    <td class="resource_cell resource_icon"><span class="icon" style="background-image: url('/uploads/subject_icons/{subject_logo}');background-size: cover;  -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover; width: 24px; height: 24px; " title="{subject_title}"></span></td>-->
                            <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?><a  href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">{title}</a><?php }else {?><a  href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">{title}</a> <?php } ?></td>
                            <td class="resource_cell name-resource">{subject_title}</td>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <!--<td class="resource_cell name-resource">{year}</td>-->
                                <td><a class='edit' href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}"></a></td>
                            <?php endif ?>
                        </tr>
                        {/lessons}
                    </table>
                    {/if}
                </div>
                <div role="tabpanel" class="tab-pane fade" id="resources_tab">
                    {if resources}
                    <h3>Resources</h3>
                    <table class='table3' style="border-top: none;">
                        <tr style="border-top: none;">
                            <th width="10%">Type</th>
                            <th>Name</th>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <th width="10%">Added By</th>
                                <!--<th width="10%">Date Added</th>-->
                                <th width="5%">Edit</th>
                            <?php endif ?>
                        </tr>
                        {resources}
                        <tr>
                            <td class="resource_cell resource_icon"><span title="{type_title}" class="icon {type}"></span></td>
                            <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?> <a href="/c2/index/resource/{resource_id}">{title}</a><?php }else{?>{title}<?php }?></td>
                            <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                                <td class='resource_cell preview-resource'>{user}</td>
                                <!--<td class="resource_cell name-resource">{date_added}</td>-->
                                <td><?php if($this->session->userdata('user_type') == 'teacher'){?>   <a class='edit' href="/c2/index/resource/{resource_id}"></a><?php }?></td>
                            <?php endif ?>
                        </tr>
                        {/resources}
                    </table>
                    {/if}
                </div>
                <div role="tabpanel" class="tab-pane fade" id="students_tab">
                    <?php if($this->session->userdata('user_type') == 'teacher'): ?>
                        {if users}
                        <h3>Students</h3>
                        <table>
                            <tr>
                                <th width="5%">Year</th>
                                <th>Name</th>
                                <th width="10%">Type</th>
                                <th width="5%"><?php if($this->session->userdata('user_type') == 'teacher'){ echo '';/* 'Edit';*/ }?></th>
                            </tr>
                            {users}
                            <tr>
                                <td class="resource_cell resource_icon"><span class="icon" style="background-image: url('/img/{year}.png');background-size: cover;  -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover; width: 24px; height: 24px; " title="{year}"></span></td>
                                <td class="resource_cell name-resource"><a href="/g2/index/{id}">{name}</a></td>
                                <td class="resource_cell name-resource">{type}</td>
                                <td><?php if($this->session->userdata('user_type') == false /*'teacher'*/ ) { ?><a class='edit' data-href="/u1/user/{id}"></a><?php }?></td>
                            </tr>
                            {/users}
                        </table>
                        {/if}
                    <?php endif ?>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="works_tab">
                    <h3>Work</h3>
                </div>

            </div>






        </div>
    </div>
</div>
