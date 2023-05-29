<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class lunch extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$this->load->model("Xin_model");
		$this->load->model("lunch_model");
		$this->load->helper('form');
	
	}

	public function index()
	{
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

        $currentDate = date('Y-m-d');
        $total_emp = $this->lunch_model->all_employees();
        $attend_emp = $this->lunch_model->daily_report('2023-01-01');
        
        $att_emp_id = array_map(function($item) {
            return $item->employee_id;
        }, $attend_emp);
        
        $activeArray = [];
        $inactiveArray = [];
        
        foreach ($total_emp as $item) {
            if (in_array($item->user_id, $att_emp_id)) {
                $activeArray[] = $item;
            } else {
                $inactiveArray[] = $item;
            }
        }


        $data['active']=$activeArray;
        $data['inactive']=$inactiveArray;
        $data['Date']=$currentDate;

		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();

		$data['breadcrumbs'] = 'lunch';
		$data['path_url'] = 'lunch';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/lunch", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}




}
?>