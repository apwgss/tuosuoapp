<?php
//dezend by http://www.yunlu99.com/
echo '' . "\r\n" . '//菜单下拉' . "\r\n" . 'var length = $(\'.header_menu\').children().length;' . "\r\n" . 'for(var i = 1;i <= length;i++){' . "\r\n" . '	var menu = $(\'.header_m_\' + i);' . "\r\n" . '	var islist = $(menu).find(\'.head_menu_list\').length;' . "\r\n" . '	if(islist){		' . "\r\n" . '		$(menu).find(\'.head_menu_icon\').show();' . "\r\n" . '	}else{		' . "\r\n" . '		$(menu).find(\'.head_menu_icon\').hide();' . "\r\n" . '	}' . "\r\n" . '	$(menu).mouseover(function(e){' . "\r\n" . '		$(this).find(\'.head_menu_list\').show();' . "\r\n" . '	});' . "\r\n" . '	$(menu).mouseout(function(e){' . "\r\n" . '		$(this).find(\'.head_menu_list\').hide();' . "\r\n" . '	});' . "\r\n" . '' . "\r\n" . '}	' . "\r\n" . '' . "\r\n" . '//左侧菜单显隐' . "\r\n" . '/*$(\'.sider_menu\').each(function(e){' . "\r\n" . '	$(this).click(function(){' . "\r\n" . '		$(this).find(\'.sider_menu_list\').toggle();		' . "\r\n" . '	});' . "\r\n" . '});*/' . "\r\n" . '' . "\r\n" . 'function menuToggle(eid)' . "\r\n" . '{' . "\r\n" . '	/*var obj = document.getElementById(eid);' . "\r\n" . '	obj.style.display=(obj.style.display==\'none\')?\'\':\'none\';*/' . "\r\n" . '}';

?>