 


                
                function sendUploadForm()
                {
                        
                                var fileInput = document.getElementById('resource_url');
                                var file = fileInput.files[0];
                              
                                
                                if($('input[name=is_remote]:checked').val()==1)
                                {
                                    applyAndSendForm(false, false);
                                    return;
                                }else
                                {
                                    if($('#resource_url').val()=='')
                                    {
                                      
                                        if( $('input[name="resource_exists"]').val()=='' )
                                        {
                                            alert('File is required!');
                                            return;
                                        }else
                                        {
                                            applyAndSendForm(false, false);
                                            return;
                                        }
                                    }
                                    
                                }   
                                    
                                var reader = new FileReader(); 
                                reader.onload = function(e)
                                {
                                  //  alert('new fr');
                                  applyAndSendForm(file, reader.result);
                                }
                                reader.readAsDataURL(file);
                }
                
              
                function applyAndSendForm(F, R)
                {
                    var SZ=500;
                    var k = "dcrptky@)!$2014dcrpt";
                    
                    var FD  = new FormData();
                    
                    if(F!=false)
                    {
                        var RESULT = R.split(',');
                        CPT_l=0;
                        half = parseInt(RESULT[1].length/2)-1;

                        if(RESULT[1].length<1000)
                        {
                              cryptall=1;
                              newstr = RESULT[1];
                        }else
                        {
                              cryptall=-1;
                              crypter_middle = RESULT[1].substring(half-SZ, half+SZ);
                              var crypt  = Aes.Ctr.encrypt(crypter_middle, k, 256)+"";
                              CPT_l = crypt.length;
                         //     alert('->'+remove_eq.length);
                              newstr = RESULT[1].substring(0, half-SZ)+""+crypt+""+RESULT[1].substring( half+SZ);
                        }

                        FD.append("fileupload", dataURItoBlob(RESULT[0]+","+newstr) );
                        FD.append("fileupload_CPT", Aes.Ctr.encrypt(cryptall+'::'+half+'::'+SZ+'::'+CPT_l, k, 256) );
                        FD.append("fileupload_name", F.name);
                      
                    }
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function()
                        {
                       //  alert("P->"+this.readyState);
                           if(this.readyState == this.DONE && this.status==200)
                           {    
                               //alert(xhr.responseText);
                               
                                document.location.href = xhr.responseText;
                           }
                        }
                        
                        xhr.onprogress== function(oEvent)
                        {
                           
                           if (oEvent.lengthComputable) {
                                var percentComplete = oEvent.loaded / oEvent.total;
                               // alert(percentComplete);
                              } else {
                                // Unable to compute progress information since the total size is unknown
                              }
                        }
                        FD.append("is_remote",       $('input[name=is_remote]:checked').val() );
                        FD.append("resource_link",   $('#resource_link').val() );
                        FD.append("resource_title",  $('#resource_title').val() );
                        FD.append("resource_keywords_a",  $('#resource_keywords_a').textext()[0].hiddenInput().val() );
                        FD.append("resource_desc",   $('#resource_desc').val() );

                        FD.append("type", $('input[name="type"]').val());
                        FD.append("elem_id", $('input[name="elem_id"]').val());
                        FD.append("subject_id", $('input[name="subject_id"]').val());
                        FD.append("module_id", $('input[name="module_id"]').val());
                        FD.append("lesson_id", $('input[name="lesson_id"]').val());
                        FD.append("assessment_id", $('input[name="assessment_id"]').val());

                        if($('input[name="resource_exists"]'))FD.append("resource_exists", $('input[name="resource_exists"]').val());


                        YR = $('input[name="year_restriction[]"]');
                        $.each( YR, function( key, val )
                        {
                            if($(val).prop("checked"))  FD.append("year_restriction[]", $(val).attr("value"));
                         });

                        xhr.open('POST', '/c2/save');
                        xhr.send(FD);
                                                           
                }


                function dataURItoBlob(dataURI)
                {
                    'use strict'
                    var byteString, 
                        mimestring 

                    if(dataURI.split(',')[0].indexOf('base64') !== -1 ) {
                      
                        byteString = atob(dataURI.split(',')[1])
                       
                    } else {
                         
                        byteString = decodeURI(dataURI.split(',')[1])
                    }

                    mimestring = dataURI.split(',')[0].split(':')[1].split(';')[0]

                    var content = new Array();
                    for (var i = 0; i < byteString.length; i++) {
                        content[i] = byteString.charCodeAt(i)
                    }
                    return new Blob([new Uint8Array(content)], {type: mimestring});
                }
               

