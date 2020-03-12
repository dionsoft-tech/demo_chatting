<?php
class Db_connect_model extends MY_Model
{
	
    public function __construct() {
        parent::__construct();
    }

	public function connect_test() {
		
		$result = new stdClass();
		$result->total_count = $this->db->count_all_results('test');
		echo $result->total_count;
        return $result;
	}
}
