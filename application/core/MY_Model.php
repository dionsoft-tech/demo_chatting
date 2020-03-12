<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Model
 *
 * @property    MY_Loader               $load
 * @property    CI_Input                $input
 * @property    CI_DB_query_builder     $db
 */
class MY_Model extends CI_Model {
	public function __construct() {
		parent::__construct();

		if (empty(defined('CURRENT_TIME_UTC'))) {
			/************************************************
			 CURRENT_TIME_UTC : DB 서버 시간 기준 : UTC
			*************************************************/
			defined('CURRENT_TIME_UTC') OR define('CURRENT_TIME_UTC', $this->get_current_time_utc());
		}
	}
	
	/**
	 * DB 서버의 UTC 00:00 시간을 리턴.
	 * @return  string
	 */
	public function get_current_time_utc() : string {
		$this->db->select('UTC_TIMESTAMP() AS CURRENT_TIME_UTC');
		$row = $this->db->get()->row_array();
		return $row['CURRENT_TIME_UTC']??'';
	}

	public function free_resource($conn_id) {
		while (mysqli_more_results($conn_id) && mysqli_next_result($conn_id)) {
			if ($result = mysqli_store_result($conn_id)) {
				mysqli_free_result($result);
			}
		}
	}
}