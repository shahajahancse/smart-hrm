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

class Lunch extends MY_Controller {
	
    public function __construct()
    {
        parent::__construct();
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $this->load->model("Xin_model");
        $this->load->model("Lunch_model");
        $this->load->model("Attendance_model");
        $this->load->model("Salary_model");
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $this->load->library('pagination');
        $this->load->model('Lunch_model');

        $config['base_url'] = base_url('admin/lunch/index');
        $config['total_rows'] = $this->Lunch_model->get_total_rows();
        $config['per_page'] = 10; // Number of records per page
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
        $data['results'] = $this->Lunch_model->get_all_data($config['per_page'], $page);
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

    public function today_lunch($id = null)
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $query = $this->db->get_where('lunch', array('date' => date('Y-m-d')));
        // dd($_POST['empid']);
        //Validation
        $this->form_validation->set_rules('empid[]', 'Employee name', 'required|trim');
        $this->form_validation->set_rules('m_amount[]', 'Meal Quantity', 'required|trim');

        //Validate and input data
        if ($this->form_validation->run() == true){

            $empid = $this->input->post('empid');
            $m_amount = $this->input->post('m_amount');
            $comment = $this->input->post('comment');
            $p_status = $this->input->post('p_status');
            $bigcomment = $this->input->post('bigcomment');
            $guest_m = $this->input->post('guest');
            $guest_comment = $this->input->post('guest_comment');
            $total_m = 0;
            $emp_m = 0;
            $total_cost = 0; 
            $emp_cost = 0; 
            $guest_cost = 0; 

            if($id != null) {
                $luncid = $id;
            } else if (!empty($query->row())) {
                 $luncid = $query->row()->id;
            } else {                
                $data = array(
                    'total_m'    => $total_m,
                    'emp_m'      => $emp_m,
                    'guest_m'    => $guest_m,
                    'total_cost' => $total_cost,
                    'emp_cost'   => $emp_cost,
                    'guest_cost' => $guest_cost,
                    'bigcomment' => $bigcomment,
                    'date'       => date('Y-m-d'),
                );
                $this->db->insert('lunch', $data);
                $luncid = $this->db->insert_id();
            } 

            $row = $this->db->where('lunch_id', $luncid)->get('lunch_details');
            if ($row->num_rows() > 0) {
                for ($i=0; $i<sizeof($empid); $i++) {
                    $emp_m += $m_amount[$i]; 
                    $form_data = array(
                        'meal_amount'   => $m_amount[$i],
                        'p_stutus'      => $p_status[$i],
                        'comment'       => $comment[$i],
                    );
                    $this->db->where('emp_id', $empid[$i])->update('lunch_details', $form_data);
                } 
            } else {
                for ($i=0; $i<sizeof($empid); $i++) {
                    $emp_m += $m_amount[$i]; 
                    $form_data[] = array(
                        'lunch_id'      => $luncid,
                        'emp_id'        => $empid[$i],
                        'meal_amount'   => $m_amount[$i],
                        'p_stutus'      => $p_status[$i],
                        'comment'       => $comment[$i],
                        'date'          => date('Y-m-d'),
                    );
                } 
                $this->db->insert_batch('lunch_details', $form_data);
            }


            $total_m = $emp_m + $guest_m;
            $total_cost = $total_m * 45;
            $emp_cost = $emp_m * 45;
            $guest_cost = $guest_m * 45;

            $data2 = array(
                'total_m' => $total_m,
                'emp_m' => $emp_m,
                'guest_m'    => $guest_m,
                'total_cost' => $total_cost,
                'emp_cost' => $emp_cost,
                'guest_cost' => $guest_cost,
            );

            $this->db->where('id', $luncid)->update('lunch', $data2);
            redirect('admin/lunch/index');
        }

        if ($query->num_rows() > 0) {
            $data['results'] = $this->Lunch_model->get_lunch_info(1);
            $data['guest'] = $query->row();
            $data['ps'] ='yes';
        } else {
            $data['results'] = $this->Lunch_model->get_lunch_info(false);
            $data['guest'] = '';
            $data['ps'] ='no';
        }

        $data['title'] = 'Lunch | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/today_lunch", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
 
    }

    public function add_lunch_pak(){
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

        $this->db->select('lunch_details.id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('lunch_details');
        $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
        $this->db->where('lunch_details.lunch_id', $lunchid);
        $this->db->where('lunch_details.date', $date);
        $this->db->where('lunch_details.meal_amount >', 0);
        $result = $this->db->get()->result();
        $data['lunch_details'] = $result;
      
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
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/lunch_report", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }

    }

    public function lunch_reports(){


        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');
        $status = $this->input->post('status');
        $emp_id = explode(',', trim($sql));

        $data['lunch_data'] = $this->Lunch_model->get_lunch_data($first_date,$second_date);


        $data['lunch_details']  = $this->Lunch_model->get_lunch_details($first_date,$second_date,$emp_id);
        $data['lunch_details_active']  = $this->Lunch_model->get_lunch_details_active($first_date,$second_date,$emp_id);
        $data['lunch_details_inactive']  = $this->Lunch_model->get_lunch_details_inactive($first_date,$second_date,$emp_id);
    
        $data['first_date'] = $first_date;
        $data['second_date'] = $first_date;
        $data['emp_id'] = $emp_id;
        if($status==1){
            $this->load->view('admin/lunch/lunch_report_view', $data); 
        }elseif($status==2){
            $this->load->view('admin/lunch/lunch_report_m', $data); 
        }elseif($status==3){
            $this->load->view('admin/lunch/lunch_report_cont', $data); 
        }elseif($status==4){
            $this->load->view('admin/lunch/lunch_report_vendor', $data); 
        }elseif($status==5){
            $this->load->view('admin/lunch/lunch_report_view_adsent', $data); 
        }
    }
    public function paymentreport(){


        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $status = $this->input->post('status');
        $data['status'] = $status;
        $data['lunch_data'] = $this->Lunch_model->paymentreport($status);
       
        $this->load->view('admin/lunch/payment_report_page', $data); 
    }

    //manually lunch data entry
    public function manual_lunch_entry(){

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        // dd($_POST);
        $this->form_validation->set_rules('empid[]', 'Employee name', 'required|trim');
        $this->form_validation->set_rules('pay_amount[]', 'Pay meal Amount', 'required|trim');
        $this->form_validation->set_rules('cost_meal[]', 'Cost meal Quantity', 'required|trim');
        $this->form_validation->set_rules('cost_amount[]', 'Cost meal Amount', 'required|trim');
        $this->form_validation->set_rules('balance[]', 'Balance Amount', 'required|trim');

        //Validate and input data
        if ($this->form_validation->run() == true){
            $empid       = $this->input->post('empid');
            $pay_amount  = $this->input->post('pay_amount');
            $cost_meal   = $this->input->post('cost_meal');
            $cost_amount = $this->input->post('cost_amount');
            $balance     = $this->input->post('balance');
            $p_meal      = $this->input->post('probability_meal');

            for ($i=0; $i<sizeof($empid); $i++) {
                $data[] = array(
                    'emp_id'      => $empid[$i],
                    'prev_meal'   => $cost_meal[$i],
                    'prev_cost'   => $cost_amount[$i],
                    'prev_pay'    => $pay_amount[$i],
                    'prev_amount' => $balance[$i],
                    'pay_amount'  => ($p_meal * 45),
                    'from_date'   => $this->input->post('from_date'),
                    'end_date'    => $this->input->post('end_date'),
                    'status'      => 0,
                );
            } 
            $this->db->insert_batch('lunch_payment', $data);
            $this->session->set_flashdata('message', 'Successfully insert done');
            return redirect('admin/lunch/index');
        }




        $data['employees'] = $this->Lunch_model->all_employees();
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Manual Lunch Entry';
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/manual_lunch_entry", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }

    }
    // manually data insert for process

    public function process_form()
    {
        // Load form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('emp_id', 'Employee ID', 'required');
        $this->form_validation->set_rules('prev_meal', 'Previous Meal', 'required');
        $this->form_validation->set_rules('prev_cost', 'Previous Cost', 'required');
        $this->form_validation->set_rules('prev_pay', 'Previous Pay', 'required');
        $this->form_validation->set_rules('prev_amount', 'Previous Amount', 'required');
        $this->form_validation->set_rules('pay_amount', 'Pay Amount', 'required');
        $this->form_validation->set_rules('from_date', 'From Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == false) {
            // Form validation failed, display error messages
            $errors = validation_errors();
            echo $errors;
        } else {
            // Form validation passed, process the form data
            $data = array(
                'prev_meal' => $this->input->post('prev_meal'),
                'prev_cost' => $this->input->post('prev_cost'),
                'prev_pay' => $this->input->post('prev_pay'),
                'prev_amount' => $this->input->post('prev_amount'),
                'pay_amount' => $this->input->post('pay_amount'),
                'from_date' => $this->input->post('from_date'),
                'end_date' => $this->input->post('end_date'),
                'status' => $this->input->post('status')
            );

            // Check if employee ID exists in the database
            $emp_id = $this->input->post('emp_id');
            $employee = $this->db->where('user_id', $emp_id)->get('xin_employees')->row();
            if ($employee) {
                $data['emp_id'] = $emp_id;

                // Check if the record already exists
                $existingRecord = $this->db->where('emp_id', $emp_id)->get('lunch_payment')->row();
                if ($existingRecord) {
                    // Update existing record
                    $this->db->where('emp_id', $emp_id)->update('lunch_payment', $data);
                    flash_message('success', 'Update Successfully');
                 
                } else {
                    // Insert new record
                    flash_message('success', 'Insert Successfully');
                    $this->db->insert('lunch_payment', $data);
                    
                }

               return redirect('admin/lunch/manual_lunch_entry');
            } else {
                return redirect('admin/lunch/manual_lunch_entry');
            }
        }
    }



    public function emp_pay_list(){

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $data['emplist'] = $this->db->query("SELECT * FROM xin_employees WHERE status IN (1, 4)")->result();


       $data['last_prement'] = $this->db->query("SELECT * FROM `lunch_payment` ORDER BY id DESC LIMIT 1")->row();
       $data['breadcrumbs'] ='Payment';
       $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/emp_pay_list", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }

    public function getfrom()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $empid = $this->input->post('selectedValue');
        $paymonth = $this->input->post('paymonth');
        // dd($empid.''.$paymonth);

        $lunch_payment = $this->db->query("SELECT lp.*, e.first_name, e.last_name
                        FROM `lunch_payment` lp
                        JOIN `xin_employees` e ON lp.emp_id = e.user_id
                        WHERE lp.`emp_id` = $empid AND lp.`end_date` = '$paymonth'")->result();

        // Set the response header as JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($lunch_payment));
    }

    public function process()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
       $firstDate = $this->input->post('firstDate');
       $secondDate = $this->input->post('secondDate');
       $data['lunch_data'] = $this->Lunch_model->process($firstDate,$secondDate);
       echo json_encode('success');
    }
    public function submit_payment() {
        // Retrieve the form data from the POST request
        $empid = $this->input->post('empid');
        $pay_month = $this->input->post('pay_month');
        $p_month_pay = $this->input->post('p_month_pay');
        $status = $this->input->post('status');

        $data = array(
            'pay_amount' => $p_month_pay,
            'status' => $status,
        );
        $this->db->where('end_date', $pay_month);
        $this->db->where('emp_id', $empid);
        $this->db->update('lunch_payment', $data);


        $response ='operation Successfull.';
        echo json_encode($response);
    }
}
?>