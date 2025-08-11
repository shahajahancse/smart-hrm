<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Debug Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Yura Loginov
 * @link		https://github.com/yuraloginoff/codeigniter-debug-helper.git
 */

// ------------------------------------------------------------------------

/**
 * Readable print_r
 *
 * Prints human-readable information about a variable
 *
 * @access	public
 * @param	mixed 
 */
if ( ! function_exists('dd'))
{
	function dd($var)
	{
		$CI =& get_instance();
		echo '<pre>' . print_r($var, TRUE) . '</pre>';
		exit;
	}
}

// ------------------------------------------------------------------------

/**
 * Readable var_dump
 *
 * Readable dump information about a variable
 *
 * @access	public
 * @param	mixed * 
 */
if ( ! function_exists('vardump'))
{
	function vardump($var)
	{
		$CI =& get_instance();
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}
}


/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */