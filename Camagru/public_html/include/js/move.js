      //object of the element to be moved
      _item = null;
 
      //stores x & y co-ordinates of the mouse pointer
      mouse_x = 0;
      mouse_y = 0;
 
      // stores top,left values (edge) of the element
      ele_x = 0;
      ele_y = 0;
 
      //bind the functions
      function move_init()
      {
        document.onmousemove = _move;
        document.onmouseup = _stop;
      }
 
      //destroy the object when we are done
      function _stop()
      {
        _item = null;
      }
 
      //main functions which is responsible for moving the element (div in our example)
      function _move(e)
      {
        mouse_x = document.all ? window.event.clientX : e.pageX;
        mouse_y = document.all ? window.event.clientY : e.pageY;
        if(_item != null)
        { 
          _item.style.left = (mouse_x - ele_x) + "px";
          _item.style.top = (mouse_y - ele_y) + "px";
        }
      }
 
      //will be called when use starts dragging an element
      function _move_item(ele)
      {
        //store the object of the element which needs to be moved
        _item = ele;
        ele_x = mouse_x - _item.offsetLeft;
        ele_y = mouse_y - _item.offsetTop;
 
      }