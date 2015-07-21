$(document).ready(function () {
    var containerOffset = 103;
    var elementHeight = 68;
    var workLabelHeight = 25;
    var workTableTHeadHeight = 64;

    if (g1_work_id > 0) {
        var workLabelElm = $('#work-' + g1_work_id);
        if (workLabelElm.length === 1) {
            var offsetMultiplier = parseInt(workLabelElm.attr('data-offset'), 10);
            var collapsedElm = $('#work-item-' + g1_work_id);
            if (collapsedElm.length === 1) {
                setTimeout(function () {
                    collapsedElm.addClass('in');
                    $(window).scrollTop(containerOffset + (offsetMultiplier * elementHeight) + workLabelHeight + workTableTHeadHeight);
                }, 1000);
            }
        }
    }
});