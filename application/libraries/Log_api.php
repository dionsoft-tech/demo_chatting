<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_api {
	
    private $success = 1;
    private $error_code = 0;
    private $error_text = '';
	
	private $header_dt = null;
    private $raw = null;
	private $raw_p = null;
    private $body = null;
	private $message = null;
	private $remote_ip = null;
	
    public function __construct() {
    }

	##################################################
	##					로그 작성					 ##
	##################################################
	public function log_message_write($supplier_id, $method, $fetch_method, $type, $msg) { 
	
		$krTime = date("Y-m-d H:i:s" , strtotime(date("Y-m-d H:i:s")."+8 hours"));
		
		if ($type == 'request') { 
			
			## GET Prameter
			//$this->raw = file_get_contents('php://input');
			$CI = & get_instance();
			$this->raw = var_export($CI->input->get(null),true);
			$this->raw_p = var_export($CI->input->post(null),true);
			$this->remote_ip = $CI->input->ip_address();
//[REQUEST] APP API (192.168.0.13) >>> [get - index] 
			## LOG Message
			$this->message = '['.strtoupper($type).'] APP API ('.$this->remote_ip.') >>> ['.$fetch_method.' - '.$method.'] '.chr(13).chr(10);
			$this->message .= '[HEADER] '.$this->header_dt.chr(13).chr(10);
			$this->message .= '[BODY - POST] '.chr(13).chr(10).$this->raw_p.chr(13).chr(10);
			$this->message .= '[BODY - GET] '.chr(13).chr(10).$this->raw;
			
		} else { 
	
			$this->message = '['.strtoupper($type).'] APP API ('.$this->remote_ip.') >>> ['.$fetch_method.'] '.chr(13).chr(10);
			//$this->message .= '[JSON]'.chr(13).chr(10);
			//$this->message .= $msg;
			$this->message .= json_encode($msg, JSON_UNESCAPED_UNICODE);
		}
		
		log_message(strtoupper($supplier_id), $this->message);
	}
	
	public function get() : array{

		/**
		* Request data(XML)
		*/
		$php_input = file_get_contents("php://input") ?? '';
		$xml = simplexml_load_string($php_input, null, LIBXML_NOCDATA);
		$array = json_decode(json_encode($xml, JSON_UNESCAPED_UNICODE), true);
		$array['method'] = $array['method'] ?? 'error';
		
		return $array;
	}
	
	public function set_error_code(int $err_no, $msg = '') : void{
		if( $this->success and $err_no ) {
			$this->success = 0;
			$this->error_code = $err_no;
			if( $msg ) $this->error_text = $msg;
			else $this->error_text = $this->_error_text[$this->error_code] ?? $this->_error_text[0];
		}
	}
	public function get_error() : array {
		return [
			'code' => $this->error_code,
			'text' => $this->error_text,
		];
	}
}