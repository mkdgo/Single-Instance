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
        },
        ajaxComplete: function () {
//            console.log('TODO: Attach AJAX Complete Events');
        }
    });

    $('#clear').click(function () {
        $('#user-results').hide();
        $('#no-users-found').hide();

        $('.results-pagination').html('');
        $('#firstName').val('');
        $('#lastName').val('');
        $('#emailAddress').val('');
        $('#userType').val('');
        $('#page').val('1');
    });

    $('#search').click(function () {
        $('#user-results table tbody tr').remove();
        $('#user-results').hide();
        $('#no-users-found').hide();
        $('.results-pagination').html('');

        $('#page').val(1);

        $.ajax({
            'url': base_url + 'admin/users/search',
            'type': 'POST',
            'dataType': 'json',
            'data': $('form#searchForm').serialize()
        }).done(function (data) {
            if (data.status) {
                if (data.data) {
                    $('#user-results').show();
                    loadResultsTable(data);
                    loadPagination(data);
                    scrollToResults();
                } else {
                    $('#no-users-found').show();
                }
            } else {
                showAJAXError();
            }
        });
    });
});

function showAJAXError() {
    alert("Uh-oh! A ninja stole our code or a horrible error occurred.");
}

function ucFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function confirmDeleteUser(usr) {
    $('.delete-user-type').text($(usr).parent().siblings('.user-type').text());
    $('.delete-user-first-name').text($(usr).parent().siblings('.user-first-name').text());
    $('.delete-user-last-name').text($(usr).parent().siblings('.user-last-name').text());
    $('#delete-user-id').val($(usr).attr('data-user-id'));
    $('#deleteUserModal').modal();
}

function deleteUser() {
    $('#deleteUserModal').modal('hide');
    $.ajax({
        'url': base_url + 'admin/users/delete',
        'type': 'POST',
        'dataType': 'json',
        'data': 'id=' + $('#delete-user-id').val()
    }).done(function (data) {
        if (data.status) {
            $('#deleteUserSuccess').modal();
            $("span[data-user-id='" + $('#delete-user-id').val() + "']").parent().parent().remove();

            var total = parseInt($('#label-total').text(), 10);
            if (total === 1) {
                $('.results-label').html('');
            } else {
                var labelSecond = parseInt($('#label-second').text(), 10);
                $('#label-second').text(labelSecond - 1);
                $('#label-total').text(total - 1);
            }

            setTimeout(function () {
                $('#deleteUserSuccess').modal('hide');
            }, 3000);
        } else {
            $('#deleteUserFailed').modal();
        }
    });
}

function showPage(elm) {
    var navigateTo = $(elm).attr('data-page-id');
    var currPage = parseInt($('#page').val(), 10);
    var goToPage = 1;

    if (navigateTo == 'previous') {
        if (currPage > 1) {
            goToPage = currPage - 1;
        }
    } else if (navigateTo == 'next') {
        goToPage = currPage + 1;
    } else {
        goToPage = parseInt(navigateTo, 10);
    }

    $('#page').val(goToPage);

    $('#user-results table tbody tr').remove();
    $('#user-results').hide();
    $('#no-users-found').hide();
    $('.results-pagination').html('');

    $.ajax({
        'url': base_url + 'admin/users/search_navigate',
        'type': 'POST',
        'dataType': 'json',
        'data': 'page=' + goToPage
    }).done(function (data) {
        if (data.status) {
            if (data.data) {
                $('#user-results').show();
                loadResultsTable(data);
                loadPagination(data);
                scrollToResults();
            } else {
                $('#no-users-found').show();
            }
        } else {
            showAJAXError();
        }
    });
}

function loadResultsTable(data) {
    $.each(data.data, function () {
        var tr = $("<tr></tr>");
        $("<td class='text-left'>" + this.id + "</td>").appendTo(tr);
        $("<td class='text-left user-first-name'>" + ucFirst(this.first_name) + "</td>").appendTo(tr);
        $("<td class='text-left user-last-name'>" + ucFirst(this.last_name) + "</td>").appendTo(tr);
        $("<td class='text-left'>" + this.email + "</td>").appendTo(tr);
        $("<td class='text-left user-type'>" + ucFirst(this.user_type) + "</td>").appendTo(tr);
        $("<td class='text-center'><span class='glyphicon glyphicon-trash text-danger' data-user-id='" + this.id + "' onclick='confirmDeleteUser(this);'></span></td>").appendTo(tr);
        tr.appendTo($('#user-results table tbody'));
    });
}

function loadPagination(data) {
    var totalCount = parseInt(data.count, 10);
    var currPage = parseInt(data.page, 10);
    var totalPages = parseInt(data.totalPages, 10);
    var filterFirst = ((currPage - 1) * 10) + 1;
    var filterSecond = '';

    if ((currPage === totalPages) || (totalPages === 0)) {
        filterSecond = totalCount;
    } else {
        filterSecond = currPage * 10;
    }

    var lbl = 'Showing <span id="label-first">' + filterFirst + '</span> - <span id="label-second">' + filterSecond + '</span> of <span id="label-total">' + totalCount + '</span> users.';
    $('.results-label').html(lbl);

    var pg = $('.results-pagination');
    if (totalPages > 1) {
        $("<li class='previous-page'><a href='javascript:;' data-page-id='previous' onclick='showPage(this);'><span>&larr;</span> Previous</a></li>").appendTo(pg);
        for (var i = 1; i <= totalPages; i++) {
            $("<li><a href='javascript:;' data-page-id='" + i + "' onclick='showPage(this);'>" + i + "</a></li>").appendTo(pg);
        }
        $("<li class='next-page'><a href='javascript:;' data-page-id='next' onclick='showPage(this);'>Next <span>&rarr;</span></a></li>").appendTo(pg);
    }

    $("a[data-page-id='" + currPage + "']").parent().addClass("active");
    $("a[data-page-id='" + currPage + "']").removeAttr('data-page-id').removeAttr('onclick');
    if (currPage === 1) {
        $('li.previous-page').addClass('disabled');
        $('li.previous-page a').removeAttr('data-page-id').removeAttr('onclick');
    }

    if (currPage === totalPages) {
        $('li.next-page').addClass('disabled');
        $('li.next-page a').removeAttr('data-page-id').removeAttr('onclick');
    }
}

function scrollToResults() {
    $('html, body').animate({
        scrollTop: $("#user-results").offset().top
    }, 100);
}