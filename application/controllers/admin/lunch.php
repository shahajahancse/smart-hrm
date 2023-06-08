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
            $currentDate = '2023-02-07';

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
                } elseif (in_array($item->emp_id, [1])) {
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
         
        if ($attend_emp == 0) {
            $activeArray = [];
            $inactiveArray = [];
            $att_emp_id = [];

            foreach ($total_emp as $item) {
                if (in_array($item->user_id, $att_emp_id)) {
                    $activeArray[] = $item;
                } else {
                    $inactiveArray[] = $item;
                }
            }
        }else{
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
        $data['path_url'] = 'report';
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

        $data['lunch_data'] = $this->lunch_model->get_lunch_data($first_date,$second_date);


        $data['lunch_details']  = $this->lunch_model->get_lunch_details($first_date,$second_date,$emp_id);
        $data['lunch_details_active']  = $this->lunch_model->get_lunch_details_active($first_date,$second_date,$emp_id);
        $data['lunch_details_inactive']  = $this->lunch_model->get_lunch_details_inactive($first_date,$second_date,$emp_id);
    
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


    public function emp_pay_list(){

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $lunch_payment =$this->db->query("SELECT * FROM `lunch_payment`")->result();

        $proccessdate=[];
        foreach ($lunch_payment as $key => $value) {
           if(!in_array($value->pay_month, $proccessdate)){
            array_push($proccessdate,$value->pay_month);

           }     
        }
        if(count($proccessdate)>0){
            $data['lastdate'] =  max($proccessdate);


        }else{
        $data['lastdate'] ="Not Prossecced";
        }


        $data['total_emp'] = $this->lunch_model->all_employees();


      $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();

        $data['breadcrumbs'] = 'Prement Report';
        $data['path_url'] = 'report';
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
      

        $lunch_payment = $this->db->query("SELECT lp.*, e.first_name, e.last_name 
        FROM `lunch_payment` lp 
        JOIN `xin_employees` e ON lp.emp_id = e.user_id
        WHERE lp.`emp_id` = $empid AND lp.`pay_month` = '$paymonth'")->result();
       

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
      
        if(base_url()=='http://localhost/smart-hrm/'){
            $currentDate = '2023-02-07';
        }else{ $currentDate = date('Y-m-d');}
            $day = date('d', strtotime($currentDate));
            $month = date('m', strtotime($currentDate));
            $year = date('Y', strtotime($currentDate));
        if ($day<12){
            $processmonth = date('Y-m-d', strtotime('-1 month', strtotime($currentDate)));
        }else{
            $processmonth=$currentDate;
        }
        
        return $this->lunch_model->process($processmonth);
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
        $this->db->where('pay_month', $pay_month);
        $this->db->where('emp_id', $empid);
        $this->db->update('lunch_payment', $data);


        $response ='operation Successfull.';
        
        echo json_encode($response);
    }
  
}
?>