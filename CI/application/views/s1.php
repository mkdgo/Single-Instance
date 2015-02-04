<div class="container">
        <div class="search_breadcrumb">Search > {query}</div>

            <div class='universal_search'> 
                <span style="margin-left: 0;" class="lesson_title">Results</span>
                <div id="all_resources">
                    
                    <!-- <div class='returned_results'>{results}</div> -->

                    {if modules}      
                        <div class='universal_results_header'>Modules</div>
                        <table>
                        <th>Name</th>
                        <th>Type</th>
                        <th><?php if($this->session->userdata('user_type') == 'teacher'){?>Edit<?php }?></th>
                            {modules}
                            <tr>
                                <td class="resource_cell name-resource">{name}</td>
                                <td class="resource_cell name-resource">{type}</td>
                                <td><?php if($this->session->userdata('user_type') == 'teacher'){?>  <a class='edit' href="/d4_teacher/index/1/{module_id}"></a><?php } ?></td>
                            </tr>
                            {/modules}
                        </table>
                    {/if}

                    {if lessons}      
                        <div class='universal_results_header'>Lessons</div>
                        <table>
                        <th>Title</th>
                        <th>Type</th>
                        <th><?php if($this->session->userdata('user_type') == 'teacher'){?>Edit<?php }?></th>
                            {lessons}
                            <tr>
                                <td class="resource_cell name-resource">{title}</td>
                                <td class="resource_cell name-resource">{type}</td>
                                <td><?php if($this->session->userdata('user_type') == 'teacher'){?><a class='edit' href="/d5_teacher/index/1/{lesson_id}"></a><?php } ?></td>
                            </tr>
                            {/lessons}
                        </table>
                    {/if}

                    {if resources}
                        <div class='universal_results_header'>Resources</div>
                        <table class='table3'>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Preview</th>
                            <th>User</th>
                            <th><?php if($this->session->userdata('user_type') == 'teacher'){?>   Edit<?php }?></th>
                                {resources}
                                <tr>
                                <td class="resource_cell resource_icon"><span class="icon {type}"></span></span></td>
                                <td class="resource_cell name-resource"><?php if($this->session->userdata('user_type') == 'teacher'){?>   <a  href="/c2/index/resource/{resource_id}">{title}</a><?php }else{?>{title}<?php }?></td>
                                <td class='resource_cell preview-resource'>{preview}</td>
                                    <td class="resource_cell name-resource">{user}</td>
                                    <td>
                                     <?php if($this->session->userdata('user_type') == 'teacher'){?>   <a class='edit' href="/c2/index/resource/{resource_id}"></a><?php }?>
                                    </td>
                                </tr>
                                {/resources}
                        </table>
                    {/if}

                    {if users}      
                        <div class='universal_results_header'>Students</div>
                        <table>
                        <th>Name</th>
                        <th>Type</th>
                        <th> <?php if($this->session->userdata('user_type') == 'teacher'){?>Edit<?php }?></th>
                            {users}
                            <tr>
                                <td class="resource_cell name-resource">{name}</td>
                                <td class="resource_cell name-resource">{type}</td>
                                <td><?php if($this->session->userdata('user_type') == 'teacher'){?><a class='edit' data-href="/u1/user/{id}"></a><?php }?></td>
                            </tr>
                            {/users}
                        </table>
                    {/if}  

                </div>
            </div>

    </div>