<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl_lib {
	
    protected $CI;

    public function __construct() {
		$this->CI =& get_instance();
    }

	#################################################
	##					Token 얻어오기				##
    #################################################
    public function _curl($url, $headers, $params, $method)
    {
		$ch = curl_init();

        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        } else {
			$url = $url."?".http_build_query($params, '', '&');
		}
		
        curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);		//10초
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
        //echo '<pre>';
        //echo '####### CURL Lib S #############################################################<br>';
        //echo 'CURL - url : '.$url.'<br>';
       // var_dump($result);
        //echo '###############################################################################<br>';
       // echo '</pre>';

		if($result === false) {

			$error_msg = curl_error($ch);
			
			curl_close($ch);
	
			$result_arr = array(
				'rs_code' => 'Error',
				'rs_msg' => $error_msg,
				'rs_data' => null
			);

		} else {
			$http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//echo "[ HTTP status code $http_status_code ]<br>";

            curl_close($ch);
			
			$data_arr = array(
				'http_status_code' => $http_status_code,
				'http_result' => $result
			);

			$result_arr = array(
				'rs_code' => 'Success',
				'rs_msg' => '',
				'rs_data' => $data_arr
			);
		}

		return $result_arr;
    }
}