<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// load interface
require_once __DIR__ . '/ThemeInterface.php';

/**
 * Class Theme_default
 */
class Theme_html_default implements ThemeInterface {
	/**
	 * @var string $htmlframe
	 */
	private $htmlframe = 'html_frame';

	/**
	 * @var string $layout
	 */
	private $layout = 'html_body';

	/**
	 * @var array $css
	 */
	private $css = [];

	/**
	* @var array $js
	*/
	private $js = [
		'header'=>[],
		'footer'=>[]
	];
	/**
	* @var array $jsscript
	*/
	private $jsscript = [
		'header'=>[ 
			//'WebFont.load({ custom: { families: ["nts", "rajdhani", "sans-serif"], urls: ["/assets/css/font.css"] } });',
			'WebFont.load({
				google: {"families":["Lato:300,400,700,900"]},
				custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["/assets/css/fonts.min.css"]},
				active: function() {
					sessionStorage.fonts = true;
				}
			});',
		],
		'footer'=>[]
	];

	/**
	* @var array $sns_meta
	*/
	private $sns_meta = [];

	/**
	 * @var array $favicon
	*/
	private $favicon = [
		'type'=>'image/png',
		'href'=>''
	];

	public function __construct () {
		$css = [
			'css/bootstrap.min.css',
			'css/atlantis.min.css',
			'css/demo.css',
			'style/common.css',
		];
		
		$js = [
			'header'=>[
				'js/plugin/webfont/webfont.min.js',
				'js/core/jquery.3.2.1.min.js',
				'js/core/popper.min.js',
				'js/core/bootstrap.min.js',
				'js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js',
				'js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js',
				'js/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
				'js/plugin/chart.js/chart.min.js',
				'js/plugin/jquery.sparkline/jquery.sparkline.min.js',
				'js/plugin/chart-circle/circles.min.js',
				'js/plugin/bootstrap-notify/bootstrap-notify.min.js',
				'js/plugin/jqvmap/jquery.vmap.min.js',
				'js/plugin/jqvmap/maps/jquery.vmap.world.js',
				'js/plugin/sweetalert/sweetalert.min.js',
				'js/atlantis.min.js',
				'scripts/common.js',
				'scripts/data_setting_ajax.js',
			],
			'footer'=>[
				'js/setting-demo.js',
			]
		];

		// css
		foreach ($css as $file_name) {
			$this->set_css($file_name);
		}

		// js
		foreach ($js as $position => $list) {
			foreach ($list as $file_name) {
				$this->set_js($file_name, $position);
			}
		}

		// favicon
		if (isset($this->favicon['href']) && $this->favicon['href']) {
			if (is_file(FCPATH . 'assets/' . $this->favicon['href'])) {
				$this->favicon['href'] = 'assets/' . $this->favicon['href'] . '?ver=' . @filemtime(FCPATH . 'assets/' . $this->favicon['href']);
			}
		}

		// sns meta
		if (isset($this->sns_meta['image']) && $this->sns_meta['image']) {
			if (is_file(FCPATH . 'assets/' . $this->sns_meta['image'])) {
				$this->sns_meta['image'] = 'assets/' . $this->sns_meta['image'] . '?ver=' . filemtime(FCPATH . 'assets/' . $this->sns_meta['image']);
			}
		}
		
		$this->set_frame('/layouts/html_frame');
		$this->set_layout('/layouts/html_body');
	}

	/**
	 * set_layout
	 *
	 * @param   string      $layout
	 *
	 * @return  void
	 */
	public function set_layout (string $layout) {
		$this->layout = $layout;
	}

	/**
	 * get_layout
	 *
	 * @return  string
	 */
	public function get_layout () : string {
		return $this->layout;
	}

	/**
	 * set_css
	 *
	 * @param   string      $css
	 *
	 * @return  void
	 */
	public function set_css (string $css) {
		if (!in_array($css, $this->css)) {
			if (is_file(FCPATH . 'assets/' . $css)) {
				$this->css[] = 'assets/' . $css . '?ver=' . @filemtime(FCPATH . 'assets/' . $css);
			} else {
				// 서버 외부의 파일..
				$this->css[] = $css;
			}
		}
	}

	/**
	 * get_css
	 *
	 * @return  array
	 */
	public function get_css () : array {
		return $this->css;
	}

	/**
	 * reset_css
	 *
	 * @return  void
	 */
	public function reset_css () {
		$this->css = [];
	}

	/**
	 * set_js
	 *
	 * @param   string      $js
	 * @param   string      $position
	 *
	 * @return  void
	 */
	public function set_js (string $js, string $position = 'footer') {
		if (isset($this->js[$position])) {
			if (!in_array($js, $this->js[$position])) {
				if (is_file(FCPATH . 'assets/' . $js)) {
					$this->js[$position][] = 'assets/' . $js . '?ver=' . @filemtime(FCPATH . 'assets/' . $js);
				} else {
					// 서버 외부의 파일..
					$this->js[$position][] = $js;
				}
			}
		} else {
			show_error('Not Match javascript Position.');
		}
	}

	/**
	 * get_js
	 *
	 * @param   string      $position
	 *
	 * @return  array       $js
	 */
	public function get_js (string $position = 'footer') : array {
		return (isset($this->js[$position]))?$this->js[$position]:[];
	}

	/**
	 * get_js
	 *
	 * @param   string      $position
	 *
	 * @return  array       get_jsscript
	 */
	public function get_jsscript (string $position = 'footer') : array {
		return (isset($this->jsscript[$position]))?$this->jsscript[$position]:[];
	}

	/**
	 * reset_js
	 *
	 * @return  void
	 */
	public function reset_js () {
		$this->js = ['header'=>[],'footer'=>[]];
	}

	/**
	 * get_favicon
	 *
	 * @param   string|null     $key
	 *
	 * @return  string|array
	 */
	public function get_favicon (string $key = null) {
		return ($key && isset($this->favicon[$key]))?$this->favicon[$key]:$this->favicon;
	}


	/**
	 * get_sns_meta
	 */
	public function get_sns_meta (string $key = null) {
		return ($key && isset($this->sns_meta[$key]))?$this->sns_meta[$key]:$this->sns_meta;
	}

	/**
	 * set_frame
	 * get_frame
	 */
	public function set_frame (string $frame) {
		$this->htmlframe = $frame;
	}
	public function get_frame () : string {
		return $this->htmlframe;
	}
}