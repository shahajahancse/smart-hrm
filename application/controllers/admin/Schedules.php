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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedules extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load the login model
        $this->load->model('Xin_model');
    }

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	//Schedule
	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('unit_id', 'Organization', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sh_type', 'Shift Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_start', 'In Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_time', 'In Time', 'trim|required|xss_clean');
		$this->form_validation->set_rules('late_start', 'Late Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_end', 'In End', 'trim|required|xss_clean');
		$this->form_validation->set_rules('out_start', 'Out Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('out_time', 'Out Time', 'trim|required|xss_clean');
		$this->form_validation->set_rules('out_end', 'Out End', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'unit_id' => $this->input->post('unit_id'),
				'sh_type' => $this->input->post('sh_type'),
				'in_start' => $this->input->post('in_start'),
				'in_time' => $this->input->post('in_time'),
				'late_start' => $this->input->post('late_start'),
				'in_end' => $this->input->post('in_end'),
				'lunch_time' => $this->input->post('lunch_time'),
				'lunch_minute' => $this->input->post('lunch_minute'),
				'out_start' => $this->input->post('out_start'),
				'out_time' => $this->input->post('out_time'),
				'out_end' => $this->input->post('out_end'),
			);

			// insert data
			if ($this->db->insert('emp_shift_schedule', $data)) {
				$this->session->set_flashdata('success', 'Inserted successfully.');
				redirect('admin/schedules/');
			}
		}

		$this->db->select("emp.*, u.name")->from("emp_shift_schedule as emp");
		$this->db->join('xin_companies as u', 'u.company_id = emp.unit_id', 'left');
		$data['results'] = $this->db->get()->result();

		$data['title'] = 'Schedule';
		$data['breadcrumbs'] = 'Schedule';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/index", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	// Schedule edit
	public function edit($id = null) {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('unit_id', 'Organization', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sh_type', 'Shift Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_start', 'In Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_time', 'In Time', 'trim|required|xss_clean');
		$this->form_validation->set_rules('late_start', 'Late Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_end', 'In End', 'trim|required|xss_clean');
		$this->form_validation->set_rules('out_start', 'Out Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('out_time', 'Out Time', 'trim|required|xss_clean');
		$this->form_validation->set_rules('out_end', 'Out End', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'unit_id' => $this->input->post('unit_id'),
				'sh_type' => $this->input->post('sh_type'),
				'in_start' => $this->input->post('in_start'),
				'in_time' => $this->input->post('in_time'),
				'late_start' => $this->input->post('late_start'),
				'in_end' => $this->input->post('in_end'),
				'lunch_time' => $this->input->post('lunch_time'),
				'lunch_minute' => $this->input->post('lunch_minute'),
				'out_start' => $this->input->post('out_start'),
				'out_time' => $this->input->post('out_time'),
				'out_end' => $this->input->post('out_end'),
			);

			// update data
			if ($this->db->where('id', $id)->update('emp_shift_schedule', $data)) {
				$this->session->set_flashdata('success', 'Update information successfully.');
				redirect('admin/schedules/');
			}
		}

		$data['row'] = $this->db->where("id", $id)->get("emp_shift_schedule")->row();

		$data['title'] = 'Schedule';
		$data['breadcrumbs'] = 'Schedule';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/edit", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	// Schedule manage
	public function shift_manage() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('unit_id', 'Organization', 'trim|required|xss_clean');
		$this->form_validation->set_rules('schedule_id', 'Schedule', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shift_name', 'Shift Name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'unit_id' => $this->input->post('unit_id'),
				'schedule_id' => $this->input->post('schedule_id'),
				'shift_name' => $this->input->post('shift_name'),
			);

			// insert data
			if ($this->db->insert('emp_shift_manage', $data)) {
				$this->session->set_flashdata('success', 'Inserted information successfully.');
				redirect('admin/schedules/shift_manage/');
			}
		}

		$this->db->select("emp.*, s.sh_type, u.name")->from("emp_shift_manage as emp");
		$this->db->join('xin_companies as u', 'u.company_id = emp.unit_id', 'left');
		$this->db->join('emp_shift_schedule as s', 's.id = emp.schedule_id', 'left');
		$data['results'] = $this->db->get()->result();

		$data['title'] = 'Manage Shift';
		$data['breadcrumbs'] = 'Manage Shift';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/shift_manage", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	// Schedule manage update
	public function manage_edit($id = null) {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('unit_id', 'Organization', 'trim|required|xss_clean');
		$this->form_validation->set_rules('schedule_id', 'Schedule', 'trim|required|xss_clean');
		$this->form_validation->set_rules('shift_name', 'Shift Name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'unit_id' => $this->input->post('unit_id'),
				'schedule_id' => $this->input->post('schedule_id'),
				'shift_name' => $this->input->post('shift_name'),
			);

			// update data
			if ($this->db->where('id', $id)->update('emp_shift_manage', $data)) {
				$this->session->set_flashdata('success', 'Update information successfully.');
				redirect('admin/schedules/shift_manage/');
			}
		}

		$data['row'] = $this->db->where("id", $id)->get("emp_shift_manage")->row();

		$data['title'] = 'Manage Shift';
		$data['breadcrumbs'] = 'Manage Shift';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/manage_edit", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	// Leave type
	public function leave_type() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('name', 'Leave Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('balance', 'Leave Amount', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'balance' => $this->input->post('balance'),
				'status' => $this->input->post('status'),
			);

			// insert data
			if ($this->db->insert('leave_type', $data)) {
				$this->session->set_flashdata('success', 'Inserted information successfully.');
				redirect('admin/schedules/leave_type/');
			}
		}

		$data['results'] = $this->db->get('leave_type')->result();

		$data['title'] = 'Leave Setup';
		$data['breadcrumbs'] = 'Leave Setup';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/leave_type", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	// Leave type
	public function leave_type_edit($id = null) {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('name', 'Leave Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('balance', 'Leave Amount', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'balance' => $this->input->post('balance'),
				'status' => $this->input->post('status'),
			);

			// update data
			if ($this->db->where('id', $id)->update('leave_type', $data)) {
				$this->session->set_flashdata('success', 'Update information successfully.');
				redirect('admin/schedules/leave_type/');
			}
		}

		$data['row'] = $this->db->where("id", $id)->get('leave_type')->row();

		$data['title'] = 'Leave Setup';
		$data['breadcrumbs'] = 'Leave Setup';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/leave_type_edit", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	// Leave setting
	public function leave_setting() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('replace_leave', 'Leave Replace', 'trim|required|xss_clean');
		$this->form_validation->set_rules('deduct_leave', 'Leave Deduct (Late)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('more_deduct', 'Leave More (Late)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'replace_leave' => $this->input->post('replace_leave'),
				'deduct_leave' => $this->input->post('deduct_leave'),
				'more_deduct' => $this->input->post('more_deduct'),
				'status' => $this->input->post('status'),
			);

			// insert data
			if ($this->db->insert('leave_settings', $data)) {
				$this->session->set_flashdata('success', 'Inserted information successfully.');
				redirect('admin/schedules/leave_setting/');
			}
		}

		$data['results'] = $this->db->get('leave_settings')->result();

		$data['title'] = 'Leave Setting';
		$data['breadcrumbs'] = 'Leave Setting';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/leave_setting", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function leave_setting_edit($id = null) {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}

		$this->form_validation->set_rules('replace_leave', 'Leave Replace', 'trim|required|xss_clean');
		$this->form_validation->set_rules('deduct_leave', 'Leave Deduct (Late)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('more_deduct', 'Leave More (Late)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'replace_leave' => $this->input->post('replace_leave'),
				'deduct_leave' => $this->input->post('deduct_leave'),
				'more_deduct' => $this->input->post('more_deduct'),
				'status' => $this->input->post('status'),
			);

			// update data
			if ($this->db->where('id', $id)->update('leave_settings', $data)) {
				$this->session->set_flashdata('success', 'Update information successfully.');
				redirect('admin/schedules/leave_setting/');
			}
		}

		$data['row'] = $this->db->where("id", $id)->get('leave_settings')->row();

		$data['title'] = 'Leave Setting';
		$data['breadcrumbs'] = 'Leave Setting';
		$data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/schedule/leave_setting_edit", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
	}

    function attn_device() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }

        $this->load->model('Xin_model');
        if (isset($_GET['name'])) {
            $data = array(
                'name' => $this->input->get('name'),
                'location' => $this->input->get('location'),
                'model' => $this->input->get('model'),
                'ip' => $this->input->get('ip'),
                'port' => $this->input->get('port'),
                'type' => $this->input->get('type'),
                'status' => $this->input->get('status'),
            );

            // insert data
            if ($this->db->insert('attn_device_setup', $data)) {
                $this->session->set_flashdata('success', 'Inserted information successfully.');
                redirect('admin/schedules/attn_device/');
            }
        }

        $data['results'] = $this->db->get('attn_device_setup')->result();

        $data['title'] = 'Device Setup';
        $data['breadcrumbs'] = 'Device Setup';
        $data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/zk_device/attn_device", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    function attn_device_edit($id = null) {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }

        $this->load->model('Xin_model');
        if (isset($_GET['name'])) {
            $data = array(
                'name' => $this->input->get('name'),
                'location' => $this->input->get('location'),
                'model' => $this->input->get('model'),
                'ip' => $this->input->get('ip'),
                'port' => $this->input->get('port'),
                'type' => $this->input->get('type'),
                'status' => $this->input->get('status'),
            );

            // insert data
            if ($this->db->where('id', $id)->update('attn_device_setup', $data)) {
                $this->session->set_flashdata('success', 'Inserted information successfully.');
                redirect('admin/schedules/attn_device/');
            }
        }

        $data['info'] = $this->db->where('id', $id)->get('attn_device_setup')->row();

        $data['title'] = 'Device Setup';
        $data['breadcrumbs'] = 'Device Setup';
        $data['path_url'] = 'schedules';

        $data['subview'] = $this->load->view("admin/zk_device/attn_device_edit", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

}
?>
