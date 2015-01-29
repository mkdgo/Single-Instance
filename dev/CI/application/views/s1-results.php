<ul class="height_480px resource_list" data-icon="false" data-role="listview" data-filter="false" data-autodividers="false" data-inset="true">
{if resources}
	{resources}
    <li>
        <span class="lesson_button">
            <a href="/c2/index/resource/{resource_id}"><div class="yesdot">EDIT</div></a>
        </span>
        <span class='resource_cell preview-resource'>{preview}</span>
        <span class="resource_cell resource_icon {filetype}"></span>
        <span class="resource_cell name-resource">{user}</span>
        <span class="resource_cell name-resource">{title}</span>

    </li>
	{/resources}
{/if}
{if !resources}<li><span class="resource_cell">No Results Found</span></li>{/if}
</ul>