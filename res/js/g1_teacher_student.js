$(document).ready(function () {
    var containerOffset = 102;
    var elementHeight = 68;
    var workLabelHeight = 25;
    var workTableTHeadHeight = 64;
    if (g1_work_id > 0) {
        var workLabelElm = $('#work-' + g1_work_id);
        if (workLabelElm.length === 1) {
            var subjectID = parseInt(workLabelElm.attr('data-parent-subject-id'), 10);
            if (subjectID > 0) {
                var subjectLabelElm = $('[data-subject-id="' + subjectID + '"]');
                if (subjectLabelElm.length === 1) {
                    var offsetMultiplier = parseInt(subjectLabelElm.attr('data-offset'), 10);
                    var pointerElm = subjectLabelElm.closest('div').find('div.up_down');
                    var collapsedElm = subjectLabelElm.closest('div').find('div.collapsed');
                    if ((pointerElm.length === 1) && (collapsedElm.length === 1)) {
                        setTimeout(function () {
                            pointerElm.css('background-position', '0 -36px');
                            collapsedElm.css('display', 'block');
                            $('#work-item-' + g1_work_id).addClass('in');
                            var tableRow = $('#work-item-' + g1_work_id).parent().parent();
                            var idx = $('tr.tr-work-' + subjectID).index(tableRow);
                            $(window).scrollTop(containerOffset + (offsetMultiplier * elementHeight) + workLabelHeight + workTableTHeadHeight + (idx * 66));
                        }, 1000);
                    }
                }
            }
        }
    }
});