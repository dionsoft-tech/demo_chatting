// JavaScript Document

$(function(){

    if (now_subMenu) { 
        $('#menu_' + now_menu).addClass('active submenu');  // 대메뉴 Light 처리
        $('#sub_' + now_menu).addClass('show');             // Sub Menu List Open 처리
        $('#sub_' + now_subMenu).addClass('active');      // 활성화 submenu Gray 처리
    } else { 
        if (now_menu) { 
            $('#menu_' + now_menu).addClass('active');  // 대메뉴 Light 처리
        }
    }
});