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
defined('BASEPATH') or exit('No direct script access allowed');

class Work_log extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load the model
        $this->load->model("Project_model");
        $this->load->model("Xin_model");
        $this->load->model("Company_model");
        $this->load->model("Department_model");
        $this->load->model("Designation_model");
        $this->load->model("Timesheet_model");
        $this->load->model("Clients_model");
        $this->load->library('email');
    }

    /*Function to set JSON output*/
    public function output($Return = array())
    {
        /*Set response header*/
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        /*Final JSON response*/
        exit(json_encode($Return));
    }
    public function index()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $system = $this->Xin_model->read_setting_info(1);
        if ($system[0]->module_projects_tasks != 'true') {
            redirect('admin/dashboard');
        }
        $data['project_data'] = $this->db->get('xin_projects')->result();
        $data['title'] = 'Work Log | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Work Log';
        $data['path_url'] = 'work_log';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        $data['subview'] = $this->load->view("admin/work_log/index", $data, true);
        $this->load->view('admin/layout/layout_main', $data);
    }
}
