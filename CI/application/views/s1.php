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
    <div class='universal_search'> 
        <span style="margin-left: 0;" class="lesson_title"><?php if(!$modules && !$lessons && !$resources && !$users){echo 'No results found for this search';} else {echo 'Results';}?> </span>
        <div id="all_resources">
            <!-- <div class='returned_results'>{results}</div> -->
            {if modules}
            <div class='universal_results_header'>Modules</div>
            <table>
                <tr>
                    <th>Name</th>
                    <th width="10%">Type</th>
                    <th width="5%"><?php if($this->session->userdata('user_type') == 'teacher'){?>Edit<?php }?></th>
                </tr>
                {modules}
                <tr>
                    <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?><a  href="/d4_teacher/index/{subject_id}/{module_id}">{name}</a><?php } else {?><a  href="/d4_student/index/{subject_id}/{module_id}">{name}</a> <?php }?></td>
                    <td class="resource_cell name-resource">{type}</td>
                    <td><?php if($this->session->userdata('user_type') == 'teacher'){?>  <a class='edit' href="/d4_teacher/index/1/{module_id}"></a><?php } ?></td>
                </tr>
                {/modules}
            </table>
            {/if}
            {if lessons}      
            <div class='universal_results_header'>Lessons</div>
            <table>
                <tr>
                    <th>Title</th>
                    <th width="10%">Type</th>
                    <th width="5%"><?php if($this->session->userdata('user_type') == 'teacher'){?>Edit<?php }?></th>
                </tr>
                {lessons}
                <tr>
                    <td class="resource_cell name-resource">
                        <?php if($this->session->userdata('user_type') == 'teacher'){?><a  href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">{title}</a><?php }else {?><a  href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">{title}</a> <?php } ?>
                    </td>
                    <td class="resource_cell name-resource">{type}</td>
                    <td><?php if($this->session->userdata('user_type') == 'teacher'){?><a class='edit' href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}"></a><?php } ?></td>
                </tr>
                {/lessons}
            </table>
            {/if}
            {if resources}
            <div class='universal_results_header'>Resources</div>
            <table class='table3'>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Preview</th>
                    <th width="10%">User</th>
                    <th width="5%"><?php if($this->session->userdata('user_type') == 'teacher'){?>   Edit<?php }?></th>
                </tr>
                {resources}
                <tr>
                    <td class="resource_cell resource_icon"><span class="icon {type}"></span></span></td>
                    <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?>   <a  href="/c2/index/resource/{resource_id}">{title}</a><?php }else{?>{title}<?php }?></td>
                    <td class='resource_cell preview-resource'>{preview}</td>
                    <td class="resource_cell name-resource">{user}</td>
                    <td><?php if($this->session->userdata('user_type') == 'teacher'){?>   <a class='edit' href="/c2/index/resource/{resource_id}"></a><?php }?></td>
                </tr>
                {/resources}
            </table>
            {/if}
            {if users}      
            <div class='universal_results_header'>Students</div>
            <table>
                <th>Name</th>
                <th width="10%">Type</th>
                <th width="5%"> <?php if($this->session->userdata('user_type') == 'teacher'){?>Edit<?php }?></th>
                {users}
                <tr>
                    <td class="resource_cell name-resource"><a href="/g2/index/{id}">{name}</a></td>
                    <td class="resource_cell name-resource">{type}</td>
                    <td><?php if($this->session->userdata('user_type') == 'teacher'){?><a class='edit' data-href="/u1/user/{id}"></a><?php }?></td>
                </tr>
                {/users}
            </table>
            {/if}
        </div>
    </div>
</div>
