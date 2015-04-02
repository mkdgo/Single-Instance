{widget_assets}


    <div class="container">
        <div class="row" style="width:110%;" >


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                {page_content_html}

                <div class="bg_img" >

                    {if image_len>1}
                    <img src="<?php echo base_url().'uploads_widgets/fill_in_the_gaps/'?>{image}" />
                    {/if}
                </div>

                <div class="preview">
                    <p>
                        {data_unformed}
                    </p>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pd15">
                    {if data_res_len >1}
                    <button type="button" class= "btn check_results">Check</button>
                    {/if}

                    <button type="button" class= "btn show_solutions">Show solutions</button>
                </div>
            </div>

        </div>





    </div>



{inline_scripting}