<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_usable('convert_file_size')) {
	/**
	 * convert_file_size
	 *
	 * bytes 의 파일용량을 다른 용량으로 변환해준다.
	 *
	 * @param   int         $size
	 * @param   string      $format
	 * @param   bool        $show_format
	 * @param   int         $decimals
	 *
	 * @return  string      $filesize
	 */
	function convert_file_size (int $size, string $format = 'B', bool $show_format = false, int $decimals = null) : string {
		$filesize = 0;
		$formats = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

		if (!(in_array($format, $formats) || in_array($format . 'B', $formats))) {
			// format 이 잘못들어왔다면..
			return $filesize;
		}

		foreach ($formats as $value) {
			if ($format == $value || $format . 'B' == $value) {
				// 들어온 용량의 시작점이라면..
				$filesize = $size;
			}

			if ($filesize < 1024) {
				// 1024로 나누어서 0보다 작으면 팅김.

				if (is_int($decimals)) {
					$filesize = number_format($filesize, $decimals);
				}

				if ($show_format) {
					$filesize .= $value;
				}

				break;
			}

			$filesize /= 1024;
		}

		return $filesize;
	}
}

if (!function_usable('convert_file_size_to_bytes')) {
	/**
	 * convert_file_size_to_bytes
	 *
	 * 파일 사이즈를 bytes 단위로 변환한다.
	 *
	 * @param   int         $size
	 * @param   string      $format
	 *
	 * @return  int         $bytes
	 */
	function convert_file_size_to_bytes (int $size, string $format) : int {
		$bytes = 0;
		$formats = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

		if (!(in_array($format, $formats) || in_array($format . 'B', $formats))) {
			// format 이 잘못들어왔다면..
			return $bytes;
		}

		$bytes = $size;
		foreach ($formats as $value) {
			if ($format == $value || $format . 'B' == $value) {
				// 현재 파일의 단위까지 도달했다면 팅김.
				break;
			}

			$bytes *= 1024;
		}

		return $bytes;
	}
}