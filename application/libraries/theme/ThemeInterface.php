<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Interface ThemeInterface
 */
interface ThemeInterface {
	/**
	 * set_layout
	 *
	 * @param   string  $layout
	 *
	 * @return  void
	 */
	public function set_layout (string $layout);

	/**
	 * get_layout
	 *
	 * @return  string
	 */
	public function get_layout () : string;

	/**
	 * set_frame
	 *
	 * @param   string  $frame
	 *
	 * @return  void
	 */
	public function set_frame (string $frame);

	/**
	 * get_frame
	 *
	 * @return  string
	 */
	public function get_frame () : string;

	/**
	 * set_css
	 *
	 * @param   string      $css
	 *
	 * @return  void
	 */
	public function set_css (string $css);

	/**
	 * get_css
	 *
	 * @return  array
	 */
	public function get_css () : array;

	/**
	 * reset_css
	 *
	 * @return  void
	 */
	public function reset_css ();

	/**
	 * set_js
	 *
	 * @param   string      $js
	 * @param   string      $position
	 *
	 * @return  void
	 */
	public function set_js (string $js, string $position = 'footer');

	/**
	 * get_js
	 *
	 * @param   string      $position
	 *
	 * @return  array
	 */
	public function get_js (string $position = 'footer') : array;

	/**
	 * reset_js
	 *
	 * @return  void
	 */
	public function reset_js ();

	/**
	 * get_favicon
	 *
	 * @param   string|null     $key
	 *
	 * @return  string|array
	 */
	public function get_favicon (string $key = null);

	/**
	 * get_sns_meta
	 */
	public function get_sns_meta (string $key = null);
}