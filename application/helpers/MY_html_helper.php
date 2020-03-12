<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('script_tag')) {
	/**
	 * script_tag
	 *
	 * @param   string      $src
	 * @param   string      $type
	 * @param   string      $charset
	 * @param   bool        $index_page
	 *
	 * @return  string      $link
	 */
	function script_tag (string $src, string $type = 'text/javascript', string $charset = '', bool $index_page = FALSE) : string {
		/**
		 * @var MY_Controller $CI
		 */
		$CI =& get_instance();
		$script = '<script ';

		if (is_array($src))
		{
			foreach ($src as $k => $v)
			{
				if ($k === 'src' && ! preg_match('#^([a-z]+:)?//#i', $v))
				{
					if ($index_page === TRUE)
					{
						$script .= 'src="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$script .= 'src="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$script .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (preg_match('#^([a-z]+:)?//#i', $src))
			{
				$script .= 'src="'.$src.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$script .= 'src="'.$CI->config->site_url($src).'" ';
			}
			else
			{
				$script .= 'src="'.$CI->config->slash_item('base_url').$src.'" ';
			}

			$script .= 'type="'.$type.'" ';
			$script .= 'charset="' . $CI->config->item('charset') . '"';
		}

		return $script."></script>\n	";
	}
}
// ------------------------------------------------------------------------

if ( ! function_exists('link_tag'))
{
	/**
	 * Link
	 *
	 * Generates link to a CSS file
	 *
	 * @param	mixed	stylesheet hrefs or an array
	 * @param	string	rel
	 * @param	string	type
	 * @param	string	title
	 * @param	string	media
	 * @param	bool	should index_page be added to the css path
	 * @return	string
	 */
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();
		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k => $v)
			{
				if ($k === 'href' && ! preg_match('#^([a-z]+:)?//#i', $v))
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->base_url($v).'" ';
					}
				}
				else
				{
					$link .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (preg_match('#^([a-z]+:)?//#i', $href))
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.$CI->config->site_url($href).'" ';
			}
			else
			{
				$link .= 'href="'.$CI->config->base_url($href).'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media !== '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title !== '')
			{
				$link .= 'title="'.$title.'" ';
			}
		}

		return $link."/>\n	";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('meta'))
{
	/**
	 * Generates meta tags from an array of key/values
	 *
	 * @param	array
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function meta($name = '', $content = '', $type = 'name', $newline = "\n")
	{
		/**
		 * @var MY_Controller $CI
		 */
		$CI =& get_instance();
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($name))
		{
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		}
		elseif (isset($name['name']))
		{
			// Turn single array into multidimensional
			$name = array($name);
		}

		$str = '';
		foreach ($name as $meta)
		{
			$type		=  isset($meta['type'])					? $meta['type'] : 'name'; //(isset($meta['type']) && $meta['type'] !== 'name')	? 'http-equiv' : 'name';
			$name		= isset($meta['name'])					? $meta['name'] : '';
			$content	= isset($meta['content'])				? $meta['content'] : '';
			$newline	= isset($meta['newline'])				? $meta['newline'] : "\n";
			if( stristr($name, 'image') ) $content = $CI->config->base_url($content);
			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline.'	';
		}

		return $str;
	}
}