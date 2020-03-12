<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_usable('print_r2')) {
	function print_r2 ($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}

if (!function_usable('destroy_session')) {
	function destroy_session () {
		session_destroy();
	}
}

if (!function_usable('chk_login')) {
	function chk_login ($sess) {
		
		$CI =& get_instance();
		
		if (!$sess) {
			echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
			echo "<script type='text/javascript'>";
			echo "location.replace('/auth/Login');";
			echo "</script>";
			exit;
		}
	}
}

if (!function_usable('console_log')) {
	function console_log ($name, $val) {
		// CONSOLE - 로그인 정보
		echo '<script>console.log("'.$name.' '.$val.'")</script>';
	}
}

if (!function_usable('alert')) {

	function alert($msg='', $url='') {

		$CI =& get_instance();

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'>";
		echo "alert('".$msg."');";
		echo "</script>";
		exit;
	}
}
 
if (!function_usable('alert_go')) {

	function alert_go($msg='', $url='') {

		$CI =& get_instance();

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'>";
		echo "alert('".$msg."');";
		
		if ($url) { 
			echo "location.replace('".$url."');";
		} else {
			echo "history.go(-1);";
		}
		echo "</script>";
		exit;
	}
}

if (!function_usable('alert_noti')) {

	function alert_noti($_from='', $_align='', $_style='', $_state='', $_title='', $_msg='', $_time='', $_delay='', $_url='', $_target='') {

		echo '<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">';
		echo '<link href="/assets/css/atlantis.min.css" rel="stylesheet" type="text/css">';
	
		echo '<script src="/assets/js/plugin/webfont/webfont.min.js"></script>';
		echo '<script src="/assets/js/core/jquery.3.2.1.min.js"></script>';
		echo '<script src="/assets/js/core/bootstrap.min.js"></script>';
		echo '<script src="/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>';
		echo '<script src="/assets/scripts/common.js"></script>';
		echo '<script>';
		echo '$(document).ready(function() {';

		echo 'WebFont.load({';
		echo 'google: {"families":["Lato:300,400,700,900"]},';
		echo 'custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["/assets/css/fonts.min.css"]},';
		echo 'active: function() {';
		echo '	sessionStorage.fonts = true;';
		echo '}';
		echo '});';

		echo 'notification("'.$_from.'", "'.$_align.'", "'.$_style.'", "'.$_state.'", "'.$_title.'", "'.$_msg.'", "'.$_time.'", "'.$_delay.'", "'.$_url.'", "'.$_target.'");';
		
		echo '});';
		echo '</script>';
	}
}
 
if (!function_usable('go_url')) {

	function go_url($url='') {

		$CI =& get_instance();

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'>";
		
		if ($url) { 
			echo "location.replace('".$url."');";
		} else {
			echo "history.go(-1);";
		}
		
		echo "</script>";
		exit;
	}
}
 
if (!function_usable('go_url_post')) {

	function go_url_post($url='', $arr_string) {

		$CI =& get_instance();
		//print_r($arr_string);
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
		echo "<script type='text/javascript'>";

        echo "var form = document.createElement('form');";

        echo "form.setAttribute('method', 'post');";
        echo "form.setAttribute('action', '".$url."');";

        echo "var hiddenField = document.createElement('input');";
        echo "hiddenField.setAttribute('type', 'hidden');";
        echo "hiddenField.setAttribute('name', 'arr_string');";
        echo "hiddenField.setAttribute('value', '".$arr_string."');";
        echo "form.appendChild(hiddenField);";

		echo "document.body.appendChild(form);";
		echo "form.submit();";

		echo "</script>";
		exit;
	}
}




