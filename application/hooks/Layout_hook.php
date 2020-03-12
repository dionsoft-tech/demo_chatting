<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Layout_hook
 */
class Layout_hook {
	/**
	 * set_layout
	 *
	 * 설정된 테마에 해당하는 레이아웃 및 head, body 를 추가해주는 함수..
	 */
	public function set_layout () {
		/**
		 * @var CI_Output $OUT
		 */
		global $OUT;
		$output = "";

		switch ($OUT->get_content_type()) {
			case 'application/json' :
				break;
				
			default :
				/**
				* @var MY_Controller $CI
				*/
				$CI =&get_instance();
				$output = $CI->output->get_output();

				// use theme
				if (isset($CI->theme)) {
					// @function get_data() from MY_Controller
					$data = $CI->get_data();
					
					// -----------------------------
					$data['html']['output'] = $output;

					// set html
					$data['html']['css'] = $CI->theme->get_css();
					$data['html']['js']['header'] = $CI->theme->get_js('header');
					$data['html']['js']['footer'] = $CI->theme->get_js('footer');
					$data['html']['jsscript']['header'] = $CI->theme->get_jsscript('header');
					$data['html']['jsscript']['footer'] = $CI->theme->get_jsscript('footer');
					$data['html']['favicon'] = $CI->theme->get_favicon();
					$data['html']['sns_meta'] = $CI->theme->get_sns_meta();

					// HTML BODY
					$layout = $CI->theme->get_layout();

					if (!empty($layout)) {
						$data['html']['output'] = $CI->load->view($data['theme_name']. $layout, $data, true);
					}
					
					// HTML FRAME
					$frame = $CI->theme->get_frame();
					if (empty($frame)) { 
						$output = $CI->load->view($data['theme_name'], $data, true);
					} else {
						$output = $CI->load->view($data['theme_name'].$frame, $data, true);
					}
					
					//print_r2($data);
					//exit;
				}
				
			break;
		}
		
		$OUT->_display($output);
	}
}