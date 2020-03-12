<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Controller
 *
 * @property    ThemeInterface      $theme
 * @property    Throttle_model      $throttle
 * @property    Api_lib             $api
 * @property    Common_model        $common         API Only
 * @property    Action_log_model    $action_log     API Only
 *
 * @property    CI_URI                  $uri
 * @property    MY_Loader               $load
 * @property    CI_Output               $output
 * @property    MY_Config               $config
 * @property    CI_Input                $input
 * @property    MY_Form_validation      $form_validation
 * @property    MY_Lang                 $lang
 * @property    CI_DB_query_builder     $db
 */
class MY_Controller extends CI_Controller {
	/**
	 * @var string $menu_active
	 */
	private $menu_active = '';
	private $menu2_active = '';
	/**
	 * @var string $theme_name
	 */
	private $theme_name = '';

	/**
	 * @var array $data
	 */
	public $data = [
		'html'=>[
			'title'=>SITE_NAME_KR,
			'site_name'=>SITE_NAME_KR,
			'description'=>"",
			'robots'=>false,
			'mobile_view'=>true
		]
	];
	
    public $api_status = array(
        200 => array('status' => 200, 'msg_u' => '', 'msg_s' => ''),
        101 => array('status' => 101, 'msg_u' => 'For generic runtime exceptions', 'msg_s' => '런타임 예외의 경우'),
        102 => array('status' => 102, 'msg_u' => 'Not Found Data', 'msg_s' => '데이터를 찾을 수 없습니다.'),
        103 => array('status' => 103, 'msg_u' => 'Session not found', 'msg_s' => '세션을 찾을 수 없습니다.'),
        104 => array('status' => 104, 'msg_u' => 'Invalid request', 'msg_s' => '잘못된 요청입니다.'),	
        105 => array('status' => 105, 'msg_u' => 'Error executing requested action', 'msg_s' => '처리 중 오류 발생.'),	
        106 => array('status' => 106, 'msg_u' => 'Session expired', 'msg_s' => '세션 만료'),
        107 => array('status' => 107, 'msg_u' => 'HTTP Method Not Allowed', 'msg_s' => '입력 방법이 올바르지 않음(http method).'),
        108 => array('status' => 108, 'msg_u' => 'Required request data is missing', 'msg_s' => '필수 요청 데이터가 누락됨.'),	
        109 => array('status' => 109, 'msg_u' => 'No more Data.', 'msg_s' => '데이터가 없습니다.'),	
        110 => array('status' => 110, 'msg_u' => 'Email address already registered.', 'msg_s' => '이미 가입된 Email 주소입니다.'),	
        111 => array('status' => 111, 'msg_u' => 'Error executing requested action [2]', 'msg_s' => '처리 중 오류 발생. [2]'),	
        112 => array('status' => 112, 'msg_u' => 'Failed Login. Please check your ID or Password.', 'msg_s' => '로그인 실패.(ID or PW 확인)')
    );
	
	public $_date_utc;
	public $_utcDate;
	public $_utcTime;
	public $_seoulTime;
	
	public $uri_step1;
	public $uri_step2;
	public $uri_step3;
	
	public $noti_opt;

	public function __construct () {
		parent::__construct();
		
		// UTC 로 timezone setting
		date_default_timezone_set('UTC');
		
		$this->load->library(['form_validation']);
		
		##########################################
		##		UTC & Asia/Seoul Time SET		##
		##########################################
		/*
		$this->_date_utc = new \DateTime("now", new \DateTimeZone("UTC"));
		$this->_utcDate = $this->_date_utc->format('Y-m-d');
		$this->_utcTime = $this->_date_utc->format('Y-m-d H:i:s');
		$this->_seoulTime = date("Y-m-d H:i:s" , strtotime($this->_utcTime."+9 hours"));
		*/
		
		$this->data['ip'] = [];
		$this->data['body_class'] = '';
		
		$this->uri_step1 = $this->uri->segment(1) ?? '';
		$this->uri_step2 = $this->uri->segment(2) ?? '';
		$this->uri_step3 = $this->uri->segment(3) ?? '';
		
		## Page theme 미 적용 Page - step2
		$curl_page_arr1 = array('api');
		$curl_page_arr2 = array('Get_refer_data', 'Reserv_status_month', 'Login');
		$curl_page_arr3 = array('update_password', 'check_password', 'admin_insert_process', 'admin_update_process', 'admin_delete_process', 'client_insert_process', 'customer_insert_process', 'login_process');

		$is_curl = true;
		if (in_array($this->uri_step1, $curl_page_arr1))	$is_curl = true;
		if (in_array($this->uri_step2, $curl_page_arr2))	$is_curl = true;
		if (in_array($this->uri_step3, $curl_page_arr3))	$is_curl = true;

		$this->noti_opt['_from'] = 'top';
		$this->noti_opt['_align'] = 'right';
		$this->noti_opt['_style'] = 'withicon';
		$this->noti_opt['_state'] = 'warning';
		$this->noti_opt['_title'] = '';
		$this->noti_opt['_msg'] = '';
		$this->noti_opt['_time'] = 1000;
		$this->noti_opt['_delay'] = 0;
		$this->noti_opt['_url'] = '';
		$this->noti_opt['_target'] = '_self';

		$this->data['sess'] = array(
			'LOGIN_SEQNO' => $this->session->LOGIN_SEQNO,
			'LOGIN_ID' => $this->session->LOGIN_ID
		);
		
		## CONSOLE - 로그인 정보
		/*
		console_log('------ 로그인 정보 -------------------------------', '');
		console_log('SESSION[LOGIN_SEQNO] : ', $this->session->LOGIN_SEQNO);
		console_log('SESSION[LOGIN_ID] : ', $this->session->LOGIN_ID);
		console_log('---------------------------------------------------', '');
		*/
		
		## CURL 통신
		if ( $is_curl === true) {
			
		## Command-line
		} else if ($this->input->is_cli_request() === true) {
			
		## Ajax 통신
		} elseif ($this->input->is_ajax_request() === true) {
			
		## Html View
		} else {
			
			switch ($this->output->get_content_type()) {
				case 'application/json' :
					
					break;
					
				default : 

						$this->data['theme_name'] = THEME_NAME;		//default
					
						$this->load->set_theme($this->data['theme_name']);
					
						// load helper
						$this->load->helper(['url','html','form','file_size','cookie']);
					
						$this->load->library(['theme/theme_'.$this->data['theme_name'] => 'theme', 'form_validation']);
					
					break;
			}
		}
	}
	
	/**
	* get_data
	*
	* @param   string|null     $key
	* @return  string|array
	*/
	public function get_data($key = null) {
		return ($key && isset($this->data[$key]))?$this->data[$key]:$this->data;
	}
	
	/**
	 * API json response
	 */
	protected function _response($result_data, int $http_code = 200) {
		$this->output->set_content_type('application/json');
		$this->output->set_status_header($http_code);
		if (is_array($result_data) === true) {
			$this->output->set_output(json_encode($result_data, JSON_UNESCAPED_UNICODE));
		} else {
			$this->output->set_output($result_data);
		}
		$this->output->_display();
		exit;
	}

	/**
	 * Sucess result json
	 */
	protected function _success($data = array()) {
		$this->_response(json_encode(array('success' => true, 'response' => $data), JSON_UNESCAPED_UNICODE), 200);
	}

	/**
	 * Fail result json
	 */
	protected function _error($error_msg, $error_code = 500) {
		$this->_response(json_encode(array('success' => false, 'error_code' => $error_code, 'error_msg' => $error_msg), JSON_UNESCAPED_UNICODE), $error_code);
	}
}