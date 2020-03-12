<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_lib extends CI_Cart {
	
	protected $CI;
	
	public $type;
	public $request_type;
	public $prd_seqNo;
	public $total_items;
	
	public function __construct ()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('cart');
	}
	
	
	###########################################
	##				장바구니 비우기			##
	###########################################
	public function _destroy()
	{
		$result = $this->CI->cart->destroy();
		
		return $result;
	}
	
	##########################################
	##				장바구니 제거				##
	##########################################
	public function _remove($row_id)
	{
		$result = $this->CI->cart->remove($row_id);
		return $result;
	}
	
	##########################################
	##				장바구니 보기				##
	##########################################
	public function _show()
	{
		//print_r($this->CI->cart->contents());
		//foreach ( $this->CI->cart->contents() as $items) { 
		//	console_log('id : ', $items['id']);
		//}
		
		$result = $this->CI->cart->contents();
		return $result;
	}
	
	##################################
	##			장바구니 수량			##
	##################################
	public function _total_cnt()
	{
		//$total_cnt = $this->CI->cart->total();
		$result = $this->CI->cart->contents();
		$total_cnt = sizeof($result);
		//console_log('_item_cnt result : ', $total_cnt);
		
		return $total_cnt;
	}
	
	####################################################
	##			장바구니 아이템별 담겼던 전체 수량 		##
	####################################################
	public function _item_cnt()
	{
		$total_cnt = $this->CI->cart->total_items();
		//console_log('_item_cnt result : ', $total_cnt);
		
		return $total_cnt;
	}
	
	##############################################
	##				장바구니 row id 얻기			##
	##############################################
	public function _get_rowID()
	{
		$result_arr = array();
		
		foreach ( $this->CI->cart->contents() as $items) { 
			//console_log('id : ', $items['id']);
			array_push( $result_arr, $items['rowid'] );
		}
		
		return $result_arr;
	}
	
	##########################################
	##				장바구니 담기				##
	##########################################
	public function _add($dataArr)
	{
		//print_r($dataArr);
		
		// Parameter
		$prd_seqNo = $dataArr['prd_seqNo'];
		$prd_name_ko = $dataArr['prd_name_ko'];
		$quantity_num = $dataArr['quantity_num'];
		$size = $dataArr['size'];
		$size_price = $dataArr['size_price'];
		
		//console_log('prd_seqNo : ', $prd_seqNo);
		//console_log('prd_name_ko : ', $prd_name_ko);
		//console_log('quantity_num : ', $quantity_num);
		//console_log('size : ', $size);
		//console_log('size_price : ', $size_price);
		
		$cart_data = array(
			'id'		=> $prd_seqNo,
			'qty'		=> $quantity_num,
			'price'		=> $size_price,
			'name'		=> $prd_name_ko,
			'options' 	=> array('size' => $size)
		);
		
		$result = $this->CI->cart->insert($cart_data);
		
		return $result;
	}
}




