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

class All_report extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Xin_model");
        $this->load->model("Location_model");
        $this->load->model("Department_model");
    }

    public function index()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $data['title'] = "All Report";
        $data['breadcrumbs'] = "All Report";
        $data['subview'] = $this->load->view("admin/all_report/all_report", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }
}
