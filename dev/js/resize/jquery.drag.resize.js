
$(function($){
 
    var isDragMouseDown    = false;
    var isResizeMouseDown    = false;

    
    var currentElement = null;

    
    var lastMouseX;
    var lastMouseY;
    var lastElemTop;
    var lastElemLeft;
    var lastElemWidth;
    var lastElemHeight;

    
    var getMousePosition = function(e){
        if (e.pageX || e.pageY) {
            var posx = e.pageX;
            var posy = e.pageY;
        }
        else if (e.clientX || e.clientY) {
            var posx = e.clientX
            var posy = e.clientY
        }
        
        
        
        return { 'x': posx, 'y': posy };
    };

    var offset_snap_grip = function(grid, size) {
        var limit = grid / 2;
        if ((size % grid) > limit) {
            return grid-(size % grid);
        } else {
            return -size % grid;
        }
    }

   
    var updatePosition = function(e, opts) {
       
        var pos = getMousePosition(e);

        var _left = (pos.x - lastMouseX) + lastElemLeft;
        var _top = (pos.y - lastMouseY) + lastElemTop;
        
        if(_top<0)
            _top=0;
        if(_left<0)
            _left=0;

        if($(currentElement).hasClass('snap-to-grid')) {
            _left = _left + offset_snap_grip(opts.grid, _left)
            _top = _top + offset_snap_grip(opts.grid, _top)
        }

        currentElement.style['top'] = _top + 'px';
        currentElement.style['left'] = _left + 'px';
        
        elmentEventPos(
                          $(currentElement),
                            _left,
                            _top
       );
        
    };

    var updateSize = function(e, opts) {
         
        var pos = getMousePosition(e);

        var _width = (pos.x - lastMouseX + lastElemWidth);
        var _height = (pos.y - lastMouseY + lastElemHeight);

        if(_width<50)
            _width=50;
        if(_height<50)
            _height=50;

        if($(currentElement).hasClass('snap-to-grid')){
            _width = _width + offset_snap_grip(opts.grid, _width)
            _height = _height + offset_snap_grip(opts.grid, _height)
        }

        currentElement.style['width'] = _width + 'px';
        currentElement.style['height'] = _height + 'px';
        
                elmentEventSize(
                          $(currentElement),
                          _width,
                          _height
                );
        
    };

    $.fn.gmPos = function(e) {
        PS = getMousePosition(e);
        return PS;
    }
    
    $.fn.dragResize = function(opts) {

        return this.each(function() {

           
            $(this).mousemove(function(e) {
                
                if(isDragMouseDown) {
                 
                    updatePosition(e, opts);
                    return false;
                }
                else if(isResizeMouseDown) {
                    
                    updateSize(e, opts);
                    return false;
                }
            });
    
            
            $(this).mouseup(function(e) {
                isDragMouseDown = false;
                isResizeMouseDown = false;
                elmentEventSave();
            });

           
            $(this).mousedown(function(e) {

                if($(e.target).hasClass('dd_handle')) {

                    var el = $(e.target).parents('.dd_block')[0];

                    isDragMouseDown = true;
                    currentElement = el;

                    
                    var pos = getMousePosition(e);
                    lastMouseX = pos.x;
                    lastMouseY = pos.y;

                    lastElemLeft = el.offsetLeft;
                    lastElemTop  = el.offsetTop;

                    updatePosition(e, opts);
                }

                if($(e.target).hasClass('dd_resize')) {
                    
                    var el = $(e.target).parents('.dd_block')[0];

                    isResizeMouseDown = true;
                    currentElement = el;

                    var pos = getMousePosition(e);
                    lastMouseX = pos.x;
                    lastMouseY = pos.y;

                    lastElemWidth  = parseInt(el.style['width'], 10);
                    lastElemHeight = parseInt(el.style['height'], 10);

                    updateSize(e, opts);
                }
                return false;
            });
        });
    };
});