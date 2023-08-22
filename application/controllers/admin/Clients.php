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

class Clients extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load the models
        $this->load->model("Clients_model");
        $this->load->model("Xin_model");
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
        if(empty($session)) {
            redirect('admin/');
        }
        $system = $this->Xin_model->read_setting_info(1);
        if($system[0]->module_projects_tasks != 'true') {
            redirect('admin/dashboard');
        }
        $data['title'] = $this->lang->line('xin_project_clients').' | '.$this->Xin_model->site_title();
        $data['all_countries'] = $this->Xin_model->get_countries();
        $data['breadcrumbs'] = $this->lang->line('xin_project_clients');
        $data['path_url'] = 'clients';
        $role_resources_ids = $this->Xin_model->user_role_resource();
        $data['subview'] = $this->load->view("admin/clients/clients_list", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function clients_list()
    {

        $data['title'] = $this->Xin_model->site_title();
        $session = $this->session->userdata('username');
        if(!empty($session)) {
            $this->load->view("admin/clients/clients_list", $data);
        } else {
            redirect('admin/');
        }
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $client = $this->Clients_model->get_clients();
        $role_resources_ids = $this->Xin_model->user_role_resource();
        $data = array();
        foreach($client->result() as $r) {
            // get country
            $country = $this->Xin_model->read_country_info($r->country);
            if(!is_null($country)) {
                $c_name = $country[0]->country_name;
            } else {
                $c_name = '--';
            }
            if(in_array('324', $role_resources_ids)) { //edit
                $edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-client_id="'. $r->client_id . '"><span class="fa fa-pencil"></span></button></span>';
            } else {
                $edit = '';
            }
            if(in_array('325', $role_resources_ids)) { // delete
                $delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->client_id . '"><span class="fa fa-trash"></span></button></span>';
            } else {
                $delete = '';
            }
            if(in_array('326', $role_resources_ids)) { //view
                $view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-client_id="'. $r->client_id . '"><span class="fa fa-eye"></span></button></span>';
            } else {
                $view = '';
            }
            $combhr = $edit.$view.$delete;

            $data[] = array(
                 $combhr,
                 $r->name,
                 $r->company_name,
                 $r->email,
                 $r->website_url,
                 $c_name,
            );
        }

        $output = array(
             "draw" => $draw,
               "recordsTotal" => $client->num_rows(),
               "recordsFiltered" => $client->num_rows(),
               "data" => $data
          );
        echo json_encode($output);
        exit();
    }
}
