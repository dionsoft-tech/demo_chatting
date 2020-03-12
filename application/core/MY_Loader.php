<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Loader
 */
class MY_Loader extends CI_Loader {
	/**
	 * @var string $theme
	 */
	protected $theme;

	public function __construct () {
		parent::__construct();
	}

	/**
	 * set_theme
	 *
	 * @param   string      $theme
	 *
	 * @return  void
	 */
	public function set_theme (string $theme) {
		$this->theme = $theme;
	}

	/**
	 * get_theme
	 *
	 * @return  string      $this->theme
	 */
	public function get_theme () : string {
		if( isset($this->theme) ) $theme = $this->theme;
		else $theme = THEME_NAME;
		return $theme;
	}

	/**
	 * theme
	 *
	 * @param   string      $view
	 * @param   array       $vars
	 * @param   bool        $return
	 *
	 * @return  string|object
	 */
	public function theme(string $view, array $vars = [], bool $return = false) {
		//echo 'o_view : '.$view.'<br>'; //mobile_user/main
		if( $this->theme ) {
			$view = $this->theme.'/' . $view;
		}
		//echo 'c_view : '.$view; //html_default/mobile_user/main
		return parent::view($view, $vars, $return);
	}
}