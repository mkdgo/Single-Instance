$(document).ready(function () {
    $body = $("body");

    $(document).on({
        ajaxStart: function () {
            $body.addClass("loading");
        },
        ajaxStop: function () {
            $body.removeClass("loading");
        },
        ajaxError: function () {
            $body.removeClass("loading");
            showAJAXError();
        }
    });

    $('#manual-fine-uploader').fineUploader({
        request: {
            endpoint: base_url + 'admin/uploading/upload_excel'
        },
        multiple: false,
        validation: {
            allowedExtensions: ['xls|xlsx|csv'],
            sizeLimit: 9120000, // 9000 kB -- 9mb max size of each file
            itemLimit: 40
        },
        autoUpload: true,
        text: {
            uploadButton: 'Upload XSL, XSLX or CSV file'
        }
    }).on('submitted', function () {
        $('#file-valid ul').html('');
        $('#file-valid').hide();
        $('#file-errors ul').html('');
        $('#file-errors').hide();
    }).on('complete', function (event, id, file_name, data) {
        $('ul.qq-upload-list').hide();
        if (data.valid) {
            $('#filename').val(data.file_name);
            $.each(data.mapped, function (k, mappingInfo) {
                var liElm = '';
                if (mappingInfo.mappedTo === null) {
                    liElm = '<li class="text-danger">Column "' + mappingInfo.column + '" ("' + mappingInfo.label + '") could not be mapped.</li>';
                } else {
                    liElm = '<li>Column "' + mappingInfo.column + '" ("' + mappingInfo.label + '") mapped to ' + mappingInfo.mappedTo + '.</li>';
                }
                $(liElm).appendTo($('#file-valid ul'));
            });

            $('#file-valid').show();
            $('html, body').animate({
                scrollTop: $('#file-valid').offset().top
            }, 100);
        } else {
            $.each(data.errors, function (k, error) {
                $('<li>' + error + '</li>').appendTo($('#file-errors ul'));
            });
            $('#file-errors').show();
            $('html, body').animate({
                scrollTop: $('#file-errors').offset().top
            }, 100);
        }
    });

    $('#importdata').click(function () {
        $.ajax({
            type: "POST",
            url: base_url + "admin/imports/import_users",
            data: 'file=' + encodeURIComponent($('#filename').val()) + '&autocreate=' + $('#autocreate').is(':checked'),
            dataType: "json",
            success: function (resp) {
                if (resp.status) {
                    $.each(resp.log, function (k, loginfo) {
                        $('<li>' + loginfo + '</li>').appendTo($('#file-success ul'));
                    });

                    $('#file-success').show();
                    $('html, body').animate({
                        scrollTop: $('#file-success').offset().top
                    }, 100);
                } else {
                    showAJAXError();
                }
            }
        });
    });
});

function showAJAXError() {
    alert("Uh-oh! A ninja stole our code or a horrible error occurred.");
}