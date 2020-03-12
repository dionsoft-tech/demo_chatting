<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Form_validation
 */
class MY_Form_validation extends CI_Form_validation {
	/**
	 * @var string $charset
	 */
	private $charset = 'UTF-8';
	
	

	/**
	 * valid_password
	 *
	 * 비밀번호 양식이 맞는지 체크
	 *
	 * @param   string      $password
	 *
	 * @return  bool
	public function valid_password (string $password) : bool {
		$count = 0;

		if (
			!$this->min_length($password, 8) ||
			!$this->max_length($password, 15)
		) {
			// 비밀번호는 8 ~ 15 자리
			return false;
		}

		if (mb_strlen(preg_replace('/[^0-9]/', '', $password), $this->charset) > 0) {
			// 숫자가 존재하는지 체크
			$count++;
		}

		if (mb_strlen(preg_replace('/[^A-Z]/', '', $password), $this->charset) > 0) {
			// 대문자가 존재하는지 체크
			$count++;
		}

		if (mb_strlen(preg_replace('/[^a-z]/', '', $password), $this->charset) > 0) {
			// 소문자가 존재하는지 체크
			$count++;
		}

		if (mb_strlen(preg_replace('/[0-9A-Za-z]/', '', $password), $this->charset) > 0) {
			// 특수문자 체크
			$count++;
		}

		if ($count < 2) {
			// 2종류 이상의 조합일때만 비밀번호로 사용 가능.
			return false;
		}

		return true;
	}

	/**
	 * valid_secure_password
	 *
	 * 보안 비밀번호 양식이 맞는지 체크
	 *
	 * @param   string      $password
	 * @param   string      $str_check
	 *
	 * @return  bool
	 *
	public function valid_secure_password (string $password, string $str_check) : bool {
		// 보안 비밀번호 자리수
		$length = 4;

		if (
			mb_strlen($password, $this->charset) != $length ||
			mb_strlen(preg_replace('/[^0-9]/', '', $password), $this->charset) != $length
		) {
			// 보안 비밀번호는 숫자 4자리
			return false;
		}

		// 보안 비밀번호 중복 체크
		$arr_overlap = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		for ($i = 0; $i < $length; $i++) {
			$arr_overlap[$password[$i]]++;
		}

		foreach ($arr_overlap as $number => $count) {
			if ($count >= 4) {
				// 중복된 숫자가 4자리 이상이라면..
				return false;
			}
		}

		// 연속된 구간 (쌍) 체크
		$int_number = 0;

		for ($i = 0; $i < $length; $i++) {
			if (
				$i > 0 &&
				(
					$password[$i] + 1 == $password[$i - 1] ||
					$password[$i] - 1 == $password[$i - 1]
				)
			) {
				// 현재 자리수의 번호가 이전 자리수의 번호와 연속된 번호일경우.
				$int_number++;
			}
		}

		if ($int_number >= 3) {
			// 연속된 번호가 특정쌍 이상이 있다면..
			return false;
		}

		// 넘어온 데이터와의 중복을 체크..
		$str = '';
		$int_str_check_length = mb_strlen($str_check, $this->charset);
		for ($i = 0; $i < $int_str_check_length; $i++) {
			if (is_numeric($str_check[$i])) {
				$str .= $str_check[$i];

				if (
					mb_strlen($str, $this->charset) >= 4 &&
					mb_substr($str, -4, 4, $this->charset) == $password
				) {
					return false;
				}
			} else {
				$str = '';
			}
		}

		return true;
	}
	*/
}