$(document).ready(function () {
    var containerOffset = 103;
    var elementHeight = 68;
    var workLabelHeight = 24;
    var workTableTHeadHeight = 64;
    var workOffset = 0;

    if (g1_subject_id > 0) {
        var subjectLabelElm = $('#subject-' + g1_subject_id);
        if (subjectLabelElm.length === 1) {
            var offsetMultiplierSubject = parseInt(subjectLabelElm.attr('data-offset'), 10);
            setTimeout(function () {
                subjectLabelElm.parent().find('div.up_down').css('background-position', '0px -36px');
                subjectLabelElm.parent().find('div.collapsed').css('display', 'block');

                if (g1_work_id > 0) {
                    var workLabelElm = $('#work-' + g1_work_id);
                    if (workLabelElm.length === 1) {
                        var offsetMultiplierWork = parseInt(workLabelElm.attr('data-offset'), 10);
                        var collapsedElm = $('#work-item-' + g1_work_id);
                        if (collapsedElm.length === 1) {
                            collapsedElm.addClass('in');
                        }
                        
                        workOffset = elementHeight + workLabelHeight + workTableTHeadHeight + (offsetMultiplierWork * elementHeight);
                    }
                }
                
                $(window).scrollTop(containerOffset + (offsetMultiplierSubject * elementHeight) + workOffset);
            }, 1000);
        }
    }

//    if (g1_work_id > 0) {
//        var workLabelElm = $('#work-' + g1_work_id);
//        if (workLabelElm.length === 1) {
//            var offsetMultiplier = parseInt(workLabelElm.attr('data-offset'), 10);
//            var collapsedElm = $('#work-item-' + g1_work_id);
//            if (collapsedElm.length === 1) {
//                setTimeout(function () {
//                    collapsedElm.addClass('in');
//                    $(window).scrollTop(containerOffset + (offsetMultiplier * elementHeight) + workLabelHeight + workTableTHeadHeight);
//                }, 1000);
//            }
//        }
//    }
});