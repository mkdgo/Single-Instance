$(function() {
$( document ).ready(function() {
    
var SZ=500;

var k = "testpass";
 var fileInput = document.getElementById('resource_url');
    
		
                
	
});
});    


                
                function sendUploadForm()
                {
                       
                                var SZ=500;
                                var k = "testpass";
                                
                               
                                var fileInput = document.getElementById('resource_url');

                                var file = fileInput.files[0];
                                var imageType = /image.*/;
                                var textType = /text.*/;

                                                var reader = new FileReader();

                                                reader.onload = function(e) {

                                                        var RESULT = reader.result.split(',');

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



                                                 //  fileDisplayArea.innerHTML = RESULT[1]

                                                        var xhr = new XMLHttpRequest();
                                                        xhr.onreadystatechange = function()
                                                        {
                                                           alert("P->"+this.readyState);
                                                           if(this.readyState == this.DONE && this.status==200)
                                                           {
                                                               alert("F->"+xhr.responseText);
                                                           }
                                                        }
                                                        
                                                        var FD  = new FormData();

                                                        FD.append("fileupload", dataURItoBlob(RESULT[0]+","+newstr) );
                                                        FD.append("fileupload_CPT", Aes.Ctr.encrypt(cryptall+'::'+half+'::'+SZ+'::'+CPT_l, k, 256) );
                                                        FD.append("fileupload_name", file.name);
                                                       // xhr.onprogress=updateProgress;
                                                       
                                                        FD.append("is_remote",       $('input[name=is_remote]:checked').val() );
                                                        FD.append("resource_link",   $('#resource_link').val() );
                                                        FD.append("resource_title",  $('#resource_title').val() );
                                                        FD.append("resource_keywords_a",  $('#resource_keywords_a').textext()[0].hiddenInput().val() );
                                                        FD.append("lesson_plenary_keywords_a",  $('#lesson_plenary_keywords_a').textext()[0].hiddenInput().val() );
                                                        FD.append("module_plenary_keywords_a",  $('#module_plenary_keywords_a').textext()[0].hiddenInput().val() );
                                                        FD.append("resource_desc",   $('#resource_desc').val() );
                                                        
                                                        FD.append("tester",   8 );
                                                        FD.append("tester",   9 );
                                                       
                                                       
                                                        xhr.open('POST', '/c2/save');
                                                        xhr.send(FD);
                                                           

                                                }
                                reader.readAsDataURL(file);					
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
               

