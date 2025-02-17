<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
    public function __construct() {

		parent::__construct();
		$ci =& get_instance();
        $ci->load->helper('language');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('url_helper');
		$this->load->helper('html');
		$this->load->database();
		$this->load->helper('security');
		$this->load->library('form_validation');
		// ini_set('session.cookie_lifetime', 0);
		$siteLang = $ci->session->userdata();

		// $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
		// $fullUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		// // dd(base_url('admin/'));
		// if($fullUrl != base_url('admin/logout') && $fullUrl != base_url('admin/auth/login') && $fullUrl != base_url('admin/')) {
		// 	// dd($fullUrl);
		// 	if($ci->session->userdata()['username']['base_url']!=base_url()){
		// 		redirect(base_url('admin/logout'));
		// 	 };
		// }

		// set default timezone
		$system = $this->read_setting_info(1);
		date_default_timezone_set($system[0]->system_timezone);
        $siteLang = $ci->session->userdata('site_lang');
		if($system[0]->default_language==''){
			$default_language = 'english';
		} else {
			$default_language = $system[0]->default_language;
		}
        if ($siteLang) {
            $ci->lang->load('hrsale',$siteLang);
        } else {
            $ci->lang->load('hrsale',$default_language);
        }
    }

	// get setting info
	public function read_setting_info($id) {

		$condition = "setting_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_system_setting');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
?>
