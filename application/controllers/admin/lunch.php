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

		$data['breadcrumbs'] = 'Lunch';
		$data['path_url'] = 'lunch';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/lunch/index", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}
	public function today_lunch()
	{
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

        $currentDate = '2023-01-01';
        $total_emp = $this->lunch_model->all_employees();
        $attend_emp = $this->lunch_model->daily_report($currentDate);
        
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
        $data['date']=$currentDate;

		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();

		$data['breadcrumbs'] = 'Lunch';
		$data['path_url'] = 'lunch';
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/lunch/today_lunch", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}
	public function add_lunch()
	{
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

    //  dd($this->input->post());

      $empid= $this->input->post('empid');
      $m_amount= $this->input->post('m_amount');
      $comment= $this->input->post('comment');
      $guest_m= $this->input->post('guest');
      $guest_comment= $this->input->post('guest_comment');
      $bigcomment= $this->input->post('bigcomment');
      $date= $this->input->post('date');



      $emp_m=0;
      foreach ($m_amount as $value) {
                if ($value == 1) {
                    $emp_m++;
                }
         }
      
      $total_m=$emp_m+$guest_m;
      $permilltk=45;
      $total_cost=$total_m*$permilltk;
      $emp_cost=$emp_m*$permilltk;
      $guest_cost=$guest_m*$permilltk;

      $data=[
        'total_m'=>$total_m,
        'emp_m'=>$emp_m,
        'guest_m'=>$guest_m,
        'total_cost'=>$total_cost,
        'emp_cost'=>$emp_cost,
        'guest_cost'=>$guest_cost,
        'date'=>$date,
      ];

      $this->db->insert('xin_announcements', $data);
      if ($this->db->affected_rows() > 0) {
          $last_id=$this->db->insert_id();
      } else {
          echo 'An error occurred';
      }

	}




}
?>