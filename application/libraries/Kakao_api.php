<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kakao_api {
	
    protected $CI;
	
    public function __construct() {
        $this->CI =& get_instance();
        
		$this->CI->load->library('Curl_lib');
    }
    
	##############################################
	##			KAKAO Map : 좌표 얻어오기			##
	##############################################
    public function get_location_addr($address)
    {
        
        $url = "https://dapi.kakao.com/v2/local/search/address.json";
        $headers = array(
			'Authorization: KakaoAK '.KAKAO_RESTAPI_KEY
        );

		$params = array(
			'query' => $address
		);

        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'get');
        
        return $rs;
    }
    
	/*
	##############################################
	##					Log Out 				##
	##############################################
    public function log_out($access_token)
    {
        
        $url = "https://kapi.kakao.com/v1/user/logout";
        $headers = array(
            'Authorization: Bearer '.$access_token
        );
        $params = '';

        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'post');
        
        return $rs;
    }
    
	#################################################
	##					Token 얻어오기				##
    #################################################
    public function get_token($code)
    {
        $url = "https://kauth.kakao.com/oauth/token";
        $redirect_uri = "http://m.splace99.co/mobile_user/Kakao";
        $client_secret = 'NP911967MVWf4r6jHxNBDGQmI4v95MNt';
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'charset=utf-8'
        );
        $params = sprintf('grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', RestAPI_Key, $redirect_uri, $code);

        //echo '<br>---------get_token_curl--------<br>';
        
        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'post');
        
        return $rs;
    }
    

	#####################################################
	##					사용자 정보 얻어오기			##
    #####################################################
    public function get_userInfo($access_token)
    {
        $url = "https://kapi.kakao.com/v2/user/me";
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$access_token,
            'charset=utf-8'
        );
        $params = '';

        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'post');
        
        return $rs;
    }


    
	#############################################
	##				카카오 연결 해제			##
	#############################################
    public function unlink($access_token)
    {
        $url = 'https://kapi.kakao.com/v1/user/unlink';
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$access_token,
            'charset=utf-8'
        );
        $params = '';

        //echo '<br>---------_curl--------<br>';
        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'post');
        
        return $rs;
    }

	#####################################################
	##				Access Token 유효성 검사			##
	#####################################################
    public function check_accessToken($access_token)
    {
        $url = "https://kapi.kakao.com/v1/user/access_token_info?access_token=".$access_token;
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$access_token,
            'charset=utf-8'
        );
        $params = '';

        //echo '<br>---------check_accessToken_curl--------<br>';
        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'get');
        
        return $rs;
    }
    
	##############################################
	##					Token 갱신				##
	##############################################
    public function refresh_token($refresh_token)
    {
       // echo 'refresh function <br>';
        //echo $refresh_token.'<br>';;

        $url = "https://kauth.kakao.com/oauth/token";
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'charset=utf-8'
        );
        $params = sprintf('grant_type=refresh_token&client_id=%s&refresh_token=%s', RestAPI_Key, $refresh_token);
        
        //echo '<br>---------refresh_token_curl--------<br>';
        $rs = $this->CI->curl_lib->_curl($url, $headers, $params, 'post');
        
        //Array ( [rs_code] => Success [rs_msg] => [rs_data] => Array ( [http_status_code] => 200 [http_result] => {"access_token":"WreBEaKPSUcoLkP3w3nbH7zHcg91Mb31TOur5Ao9dqQAAAFvrTFeJA","token_type":"bearer","expires_in":21599} ) )
        
        return $rs;
    }
	*/
}