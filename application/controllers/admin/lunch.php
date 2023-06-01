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
	
	public function __construct()
{
    parent::__construct();
    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }

    $this->load->model("Xin_model");
    $this->load->model("lunch_model");
    $this->load->model("Attendance_model");
    $this->load->model("Salary_model");
    $this->load->helper('form');
}

public function index()
{
    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }

    $this->load->library('pagination');
    $this->load->model('lunch_model');

    $config['base_url'] = base_url('admin/lunch/index');
    $config['total_rows'] = $this->lunch_model->get_total_rows();
    $config['per_page'] = 2; // Number of records per page
    $config['uri_segment'] = 3; // Update the URI segment number to 2
    
    // Bootstrap 3 pagination style
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $data['results'] = $this->lunch_model->get_all_data($config['per_page'], $page);
    $data['pagination'] = $this->pagination->create_links();
    $data['query'] = $this->db->get_where('lunch_package', array('id' => 1))->result();

    $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

    $data['breadcrumbs'] = 'Lunch';
    $data['path_url'] = 'lunch';
    if (!empty($session)) {
        $data['subview'] = $this->load->view("admin/lunch/index", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    } else {
        redirect('admin/');
    }
}

public function today_lunch()
{
    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }


    if(base_url()=='http://localhost/smart-hrm/'){
        $currentDate = '2023-01-05';

    }else{ $currentDate = date('Y-m-d');}
    $query = $this->db->get_where('lunch_details', array('date' => $currentDate))->result();
    if (count($query) > 0) {
        $activeArray = [];
        $inactiveArray = [];
        $guest = [];

        foreach ($query as $item) {
            if (in_array($item->p_stutus, ['present'])) {
                $activeArray[] = $item;
            } elseif (in_array($item->p_stutus, ['absent'])) {
                $inactiveArray[] = $item;
            } elseif (in_array($item->p_stutus, ['guest'])) {
                $guest[] = $item;
            }
        }

        $querybig = $this->db->get_where('lunch', array('id' => $query[0]->lunch_id))->result();

        $data['active'] = $activeArray;
        $data['inactive'] = $inactiveArray;
        $data['guest'] = $guest;
        $data['date'] = $currentDate;
        $data['bigcom'] = $querybig[0]->bigcomment;

        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/today_lunch", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    } else {
        $total_emp = $this->lunch_model->all_employees();
        $attend_emp = $this->lunch_model->daily_report($currentDate);
        dd($attend_emp);

        $att_emp_id = array_map(function ($item) {
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

        $data['active'] = $activeArray;
        $data['inactive'] = $inactiveArray;
        $data['date'] = $currentDate;

        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/today_lunch", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }
}

public function add_lunch()
{
    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }

    $empid = $this->input->post('empid');
    $m_amount = $this->input->post('m_amount');
    $comment = $this->input->post('comment');
    $guest_m = $this->input->post('guest');
    $guest_comment = $this->input->post('guest_comment');
    $bigcomment = $this->input->post('bigcomment');
    $date = $this->input->post('date');
    $p_status = $this->input->post('p_status');

    $emp_m = 0;
    foreach ($m_amount as $value) {
        $emp_m += $value;
    }

    $total_m = $emp_m + $guest_m;
    $permilltk = 45;
    $total_cost = $total_m * $permilltk;
    $emp_cost = $emp_m * $permilltk;
    $guest_cost = $guest_m * $permilltk;

    $query = $this->db->get_where('lunch', array('date' => $date))->result();

    if (count($query) > 0) {
        $data = array(
            'total_m' => $total_m,
            'emp_m' => $emp_m,
            'guest_m' => $guest_m,
            'total_cost' => $total_cost,
            'emp_cost' => $emp_cost,
            'guest_cost' => $guest_cost,
            'bigcomment' => $bigcomment,
        );
        $luncid = $query[0]->id;

        $this->db->where('id', $query[0]->id);
        if ($this->db->update('lunch', $data)) {
            $this->lunch_model->add_lunch_update($luncid, $empid, $m_amount, $p_status, $comment, $guest_m, $guest_comment, $date);
            redirect('admin/lunch/index');
        } else {
            exit('not updated');
        }
    } else {
        $data = array(
            'total_m' => $total_m,
            'emp_m' => $emp_m,
            'guest_m' => $guest_m,
            'total_cost' => $total_cost,
            'emp_cost' => $emp_cost,
            'guest_cost' => $guest_cost,
            'bigcomment' => $bigcomment,
            'date' => $date,
        );

        if ($this->db->insert('lunch', $data)) {
            $luncid = $this->db->insert_id();
            $this->lunch_model->add_lunch_details($luncid, $empid, $m_amount, $p_status, $comment, $guest_m, $guest_comment, $date);
            redirect('admin/lunch/index');
        } else {
            exit('not inserted');
        }
    }
}
public function add_lunch_pak()
	{
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

      // Get form data
      $perMilValue = $this->input->post('per_mil');
      $officeGivePercentValue = $this->input->post('office_give_percent');
      $stufGivePercentValue = $this->input->post('stuf_give_percent');
      $officeGiveTkValue = $this->input->post('office_give_tk');
      $stufGiveTkValue = $this->input->post('stuf_give_tk');
  
      // Perform necessary operations with the data
      // For example, update data in the database
  
      $data = array(
          'permeal' => $perMilValue,
          'office_givepercent' => $officeGivePercentValue,
          'stuf_give_percent' => $stufGivePercentValue,
          'office_give_tk' => $officeGiveTkValue,
          'stuf_give_tk' => $stufGiveTkValue
      );
  
      $this->db->where('id', 1); // Assuming you have an 'id' field in your database table to identify the record to update
      $this->db->update('lunch_package', $data);
  

    
	}

public function lunch_package(){
    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }


    $data['query'] = $this->db->get_where('lunch_package', array('id' => 1))->result();

    $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

    $data['breadcrumbs'] = 'Lunch Package';
    $data['path_url'] = 'lunch';
    if (!empty($session)) {
        $data['subview'] = $this->load->view("admin/lunch/lunch_package", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    } else {
        redirect('admin/');
    }


}

public function details($lunchid, $date){
    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }

    $data['lunch_details'] = $this->db->get_where('lunch_details', array('lunch_id' => $lunchid, 'date' => $date, 'meal_amount >' => 0))->result();
    $data['lunch'] = $this->db->get_where('lunch', array('id' =>$lunchid, 'date' =>$date ))->result();

    $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

    $data['breadcrumbs'] = 'Lunch Details';
    $data['path_url'] = 'details';
    if (!empty($session)) {
        $data['subview'] = $this->load->view("admin/lunch/lunch_details", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    } else {
        redirect('admin/');
    }
}

public function report(){

    $session = $this->session->userdata('username');
    if (empty($session)) {
        redirect('admin/');
    }





  $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

    $data['breadcrumbs'] = 'Lunch Report';
    $data['path_url'] = 'report';
    if (!empty($session)) {
        $data['subview'] = $this->load->view("admin/lunch/lunch_report", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    } else {
        redirect('admin/');
    }

}
}
?>