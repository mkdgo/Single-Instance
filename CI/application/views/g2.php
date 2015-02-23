<div data-role="header" data-position="inline">
    <a href="{back}" data-icon="arrow-l">back</a>
    <div class="header_search hidden-xs">
        <input type="search" id="search" style="" value=""/>
    </div>
    <h1>Student profile</h1>
</div>

<div>
    <br/><br/><br/>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <strong>Student list</strong><br/>
                <br/>
                <ul  class="height_480px" data-icon="false" data-role="listview"  data-filter="true" data-autodividers="true" data-inset="true">
                    {students}
                    <li><a href="{url}" class="online_text">{first_name} {last_name}</a></li>
                    {/students}
                </ul>
                <a href="#" data-role="button" data-mini="true" class="hidden">Post lesson analysis</a>
                <a href="#" data-role="button" data-mini="true" class="hidden">Stop lesson</a>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="row">
                    {student}
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 top_350px align_left">
                        <a href="{prev}" data-role="button" data-icon="arrow-l" data-iconpos="notext" class="{prev_hidden}"></a>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 row">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 row align_center">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {first_name} {last_name}<br />
                                <img src="/img/face.jpg" class="img_200x200"/><br/>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 align_left">
                                <a href="{prev_year}" data-role="button" data-icon="arrow-l" data-iconpos="notext" class="{prev_year_hidden}"></a>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 align_center">
                                <strong>Year {year}</strong><br/>
                                {classes}
                                {subject_name} {year}{group_name}<br/>
                                {/classes}
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 align_right">
                                <a href="{next_year}" data-role="button" data-icon="arrow-r" data-iconpos="notext" class="{next_year_hidden}"></a>
                            </div>
                        </div> 

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <strong>Tagged resources</strong><br/><br/>
                            resource 1<br/>
                            resouce 2<br/>
                            resource 3
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 top_350px align_right">
                        <a href="{next}" data-role="button" data-icon="arrow-r" data-iconpos="notext" class="{next_hidden}"></a>
                    </div>
                    {/student}
                </div>
            </div>
        </div>
    </div>
</div>