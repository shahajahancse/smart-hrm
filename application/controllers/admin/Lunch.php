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
        $this->load->library('form_validation');
        $this->load->helper('date');
    }

    public function index()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $data['results'] = $this->Lunch_model->get_all_data();
        // dd($data['results']);
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        $data['session'] = $session;

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
         
        $date = date('Y-m-d',strtotime($this->input->post('date')));
       

        
        if ($this->input->post('date')==null) {
            if($id!=null) {
                $this->db->where('id', $id);
                $query = $this->db->get('lunch');
                $datas = $query->result();
                $date=$datas[0]->date;

            }else{
            $date= date('Y-m-d');
            }
        }else {
            $date= date('Y-m-d',strtotime($this->input->post('date')));
        }

    
        $data['date'] =$date;
     
        $query = $this->db->get_where('lunch', array('date' => $date));
        // dd($_POST['empid']);
        //Validation
        $this->form_validation->set_rules('empid[]', 'Employee name', 'required|trim');
        $this->form_validation->set_rules('m_amount[]', 'Meal Quantity', 'required|trim');

        //Validate and input data
    
        if ($this->form_validation->run() == true && $this->input->post('change')==0){
            $empid = $this->input->post('empid');
            $m_amount = $this->input->post('m_amount');
            $comment = $this->input->post('comment');
            $p_status = $this->input->post('p_status');
            $bigcomment = $this->input->post('bigcomment');
            $guest_m = $this->input->post('guest');
            $guest_comment = $this->input->post('guest_comment');
            if($this->input->post('status')==1){
                $status=2; 
            }else{
                $status=1;  
            }  
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
                    'date'       => $date,
                    'status'       => $status,
                );
                $this->db->insert('lunch', $data);
                $luncid = $this->db->insert_id();
                // dd( $luncid );
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
                    $this->db->where('date', $date);
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
                        'date'          => $date,
                    );
                } 
                $this->db->insert_batch('lunch_details', $form_data);
            }

            $total_m = $emp_m + $guest_m;
            $total_cost = ($emp_m*45) + ($guest_m* 90);
            $emp_cost = $emp_m * 45;
            $guest_cost = $guest_m * 90;

            $data2 = array(
                'total_m' => $total_m,
                'emp_m' => $emp_m,
                'guest_m'    => $guest_m,
                'total_cost' => $total_cost,
                'emp_cost' => $emp_cost,
                'guest_cost' => $guest_cost,
                'bigcomment' => $bigcomment,
                'status' => $status,
            );

            $this->db->where('id', $luncid)->update('lunch', $data2);
            redirect('admin/lunch/index');
        }
        
        if ($query->num_rows() > 0) {
            $data['results'] = $this->Lunch_model->get_lunch_info(1,$date);
            $data['guest'] = $query->row();
            $data['ps'] ='yes'; 
        } else {
         

            $data['results'] = $this->Lunch_model->get_lunch_info(false,$date);
            // dd( $data['results']);
            $data['guest'] = '';
            $data['ps'] ='no';
        }
        // dd($data['results']);
        $data['title'] = 'Lunch | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        if ($id!=null){
            $data['date'] = $this->db->get_where('lunch', array('id' => $id))->result()[0]->date;
        }
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
        // $this->db->where('lunch_details.meal_amount >', 0);
        $result = $this->db->get()->result();
        $data['lunch_details'] = $result;
        // dd($data['lunch_details']);
      
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

    public function lunch_reports($elc=null){
       
        // dd($elc);
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
       
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        // dd($first_date .'-'. $second_date);
        $sql = $this->input->post('sql');
        $status = $this->input->post('status');
        $emp_id = explode(',', trim($sql));

        $data['lunch_data'] = $this->Lunch_model->get_lunch_data($first_date,$second_date);


        $data['lunch_details']  = $this->Lunch_model->get_lunch_details($first_date,$second_date,$emp_id);
        $data['lunch_details_active']  = $this->Lunch_model->get_lunch_details_active($first_date,$second_date,$emp_id);
        $data['lunch_details_inactive']  = $this->Lunch_model->get_lunch_details_inactive($first_date,$second_date,$emp_id);
    
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['emp_id'] = $emp_id;
        if($elc==1){
            // dd($data['lunch_data'] );
            $this->load->view('admin/lunch/lunch_report_cont_exl', $data); 
        }else{
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
}

    public function conempmeal($ex=null){
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');

        $status = $this->input->post('status');
        $emp_id = explode(',', trim($sql));
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['emp_id'] = $emp_id;
        $data['status'] = $status;
        $data['sql'] = $sql;
        if($ex==1){
            $this->load->view('admin/lunch/emp_con_report_ex', $data); 
        }else{
            $this->load->view('admin/lunch/emp_con_report', $data); 
        }
    }

    public function paymentreport($r=null){
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $status = $this->input->post('status');
        $excel = $this->input->post('excel');
        $data['status'] = $status;
        $data['lunch_data'] = $this->Lunch_model->paymentreport($status);
        $data['r'] = $r;

        if($r==1){
            
            if($excel==1){
                $this->load->view('admin/lunch/previous_report_page_exel', $data);

            }else{
                $this->load->view('admin/lunch/previous_report_page', $data); }
        }else{


            if($excel==1){
                $this->load->view('admin/lunch/payment_report_page_exel', $data);

            }else{
                $this->load->view('admin/lunch/payment_report_page', $data); }}
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
      
        // status
       $firstDate =date('Y-m-d', strtotime($this->input->post('firstDate')));

       $secondDate = $this->input->post('secondDate');
       $probable_date = $this->input->post('probable_date');
       if($this->input->post('status')==1){
        $this->db->where('from_date', $firstDate);
        $this->db->where('end_date', $secondDate);
        $this->db->delete('lunch_payment');
    };
   
       $data['lunch_data'] = $this->Lunch_model->process($firstDate,$secondDate,$probable_date);
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
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('end_date', $pay_month);
        $this->db->where('emp_id', $empid);
        $this->db->update('lunch_payment', $data);


        $response ='operation Successfull.';
        echo json_encode($response);
    }
    public function vendor_payment() {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        $data['result'] = $this->db->order_by('id', 'desc')->get('lunch_payment_vendor', 1)->row();
        $data['payment_data'] = $this->db->get('lunch_payment_vendor')->result();
       
     
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/vendor_payment", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }



    }
    public function get_payment_data() {
       echo $total_m= $this->Lunch_model->chack_meal($this->input->post('first_date'),$this->input->post('second_date'));
   
    }
    public function make_payment() {
       
        $pre_due=$this->input->post('pre_due');
        $fromDate=$this->input->post('fromDate');
        $toDate=$this->input->post('toDate');
        $totalMeal=$this->input->post('totalMeal');
        $totalAmount=$this->input->post('totalAmount');
        $payableAmount=$this->input->post('payableAmount');
        $dueAmount=$this->input->post('dueAmount');
        $paid_amount=$this->input->post('payAmount');
        $remarks=$this->input->post('remarks');
        $last_collection_id=$this->input->post('last_collection_id');
            if($last_collection_id!==null){;
            $data = array(
                'status' => 1,
            );
            $this->db->where('id', $last_collection_id);
            $this->db->update('lunch_payment_vendor', $data);
            }
           if($dueAmount==0){
                $status=1;
            }else{
                $status=0;
            }
         
        $data = array(
            'previous_due' => $pre_due,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'total_meal' => $totalMeal,
            'pay_amount' => $totalAmount,
            'net_payment' => $payableAmount,
            'paid_amount' => $paid_amount,
            'due' => $dueAmount,
            'date' => date('Y-m-d'),
            'Remarks' => $remarks,
            'status' => $status,
        );
        if($this->db->insert('lunch_payment_vendor', $data)){
            echo 'success';
        }else{
            echo 'there was an error';
        };
    }
public function make_id_payment(){
    $dueAmount=$this->input->post('deu_amount');
    $pay_Amount=$this->input->post('amount');
    $id=$this->input->post('rawid');
    $prepaid=$this->input->post('prepaid');
    $present_deu=$this->input->post('present_deu');

    $paid_amo=$prepaid+$pay_Amount;
    // $due_amo=

    if($present_deu>0){
        $status=0;
    }else{
        $status=1;
    }

    $data = array(
        'paid_amount' => $paid_amo,
        'due' => $present_deu,
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s'),
    );
    $this->db->where('id', $id);
    if($this->db->update('lunch_payment_vendor', $data)){
        echo "success!";
    }else{
        echo "Unsuccess!";
    };
}
    //working here razibul 22-06-2023
	public function vendor_status_report($exl=null){

        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        
     
        $data["values"] = $this->Lunch_model->vendor_status_report($f1_date, $f2_date);

    //   dd($data["values"]);
       
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
       if($exl==1){
        $this->load->view("admin/lunch/vendor_status_report_exl", $data);
       }else{
        if(is_string($data["values"]))
        {
            echo $data["values"];
        }
        else
        {	
            echo $this->load->view("admin/lunch/vendor_status_report", $data, TRUE);
        }
    }

}
    public function lunch_jobcard(){
        $session = $this->session->userdata('username');
            if (empty($session)) {
                redirect('admin/');
            }
        
         
            $first_date = $this->input->post('first_date');
            $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['company_info'] = $this->Xin_model->get_company_info(1);
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
        echo $this->load->view("admin/lunch/lunch_jobcard", $data, TRUE);
    }
    public function lunch_off(){
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $reason=$this->input->post('reason');
        $dateoff=$this->input->post('dateoff');

        $query = $this->db->get_where('lunch', array('date' => $dateoff))->result();
        // dd($query[0]->id);
        if(count($query)>0){
          
            $data = array(
             'total_m' => 0,
             'emp_m' => 0,
             'guest_m' => 0,
             'total_cost' => 0,
             'emp_cost' => 0,
             'guest_cost' => 0.00,
             'package_id' => 0,
             'status' => 2,
             'bigcomment' => $reason,
             'guest_ref_id' => '',
             'guest_ref_comment' => '',
            );
            $this->db->where('date', $dateoff);
            if($this->db->update('lunch', $data)){
                $lunchid=$query[0]->id;
                $data2 = array(
                    'meal_amount' => 0,
                    'comment' => '',
                );
                $this->db->where('lunch_id', $lunchid);
                $this->db->update('lunch_details', $data2);
            }else{
                echo "there was an error";
            }
        }else{
            $data = array(
                'total_m' => 0,
                'emp_m' => 0,
                'guest_m' => 0,
                'total_cost' => 0,
                'emp_cost' => 0,
                'guest_cost' => 0.00,
                'package_id' => 0,
                'status' => 2,
                'bigcomment' => $reason,
                'guest_ref_id' => '',
                'guest_ref_comment' => '',
                'date' => $dateoff ,
               );
               if($this->db->insert('lunch', $data)){
                $insert_id = $this->db->insert_id();
                $emp = $this->db->query("SELECT * FROM xin_employees WHERE status IN (1, 4)")->result();
        
                foreach($emp as $row){
                    $dateoff = date("Y-m-d", strtotime($dateoff));
                    $this->db->select('*');
                    $this->db->from('xin_attendance_time');
                    $this->db->where('employee_id', $row->user_id);
                    $this->db->where('attendance_date', $dateoff);
                    $result = $this->db->get()->row();

                   
                    // dd($p_status);
                    $data2 = array(
                    'lunch_id'      => $insert_id,
                    'emp_id'        => $row->user_id,
                    'meal_amount'   => 0,
                    'p_stutus'      => $result->status,
                    'comment'       => '',
                    'date'          => $dateoff,
                       );
                    $this->db->insert('lunch_details', $data2);

                }
               }else{
                   echo "there was an error";
               }

        };
        



    }
    public function employee_list(){
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $result = $this->db->order_by('id', 'desc')->get('lunch_payment', 1)->row();
        $data['first_date']=$result->end_date;
        $data['second_date']=$result->next_date;
        $data['empdata'] = $this->db
        ->select('lunch_payment.*, xin_employees.first_name, xin_employees.last_name, xin_designations.designation_name')
        ->from('lunch_payment')
        ->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id')
        ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id')
        ->where('lunch_payment.end_date', $result->end_date)
        ->order_by('lunch_payment.id', 'desc')
        ->get()
        ->result();
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch';
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/emp_list", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
       
    }


public function pay_vend_ajax_request()
{
            $id = $this->input->post('id');
            $statusC = $this->input->post('statusC');

       

            $data["values"] = $this->Lunch_model->pay_vend_ajax_request($id);

            $data["from_date"] = $data["values"][0]->from_date;
            $data["to_date"] = $data["values"][0]->to_date;
            $data["f_date"] = $data["values"][0]->date;
          
            if(is_string($data["values"]))
            {
                echo $data["values"];
            }
            else
            {	
                echo $this->load->view("admin/lunch/v_report", $data, TRUE);
            }

    
     
}


    public function sethrp() {
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        if ($status==1) {
            $if_eidit=0;
        }else{
            $if_eidit=1;
        }
     
        $data = array(
            'if_eidit' => $if_eidit
        );
        $this->db->where('id', $id);
        $this->db->update('lunch', $data);
    }

    public function vendor_lunch_list() {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch Vendor Meal';
        $data['path_url'] = 'lunch';
        $data['payment_data'] = $this->db->get('lunch_vendor_meal')->result();
       
     
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/lunch/vendor_lunch_list", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }


    // ============================ Vendor Pakage Payment ============================

	public function lunch_menu($id = null){
     

		$session = $this->session->userdata('username');
		//  dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}
        // dd($session);

		$this->form_validation->set_rules('name', 'Pakage name', 'required|trim');
		$this->form_validation->set_rules('description', 'address', 'required|trim');

		if ($this->form_validation->run() == true){
			$menu_data = array( 
					'pakage_name'		 => $_POST['name'],
					'details'	 => $_POST['description'],
					
				);				 
									
			if ($hid = $this->input->post('hid')) {
				$this->db->where('id', $hid)->update('lunch_vendor_menu', $menu_data);
				$this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Lunch_model->save('lunch_vendor_menu', $menu_data)){
					$this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
		}
						

		//Dropdown
		$data['title'] 			= 'Lunch | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Vendor Pakage';
        $this->db->order_by('id', 'desc');
        $data['menulist'] = $this->db->get("lunch_vendor_menu")->result();
		$data['col'] 			= $id;
		$data['user_role_id'] 	= $session['role_id'];
		
		$data['subview'] 		= $this->load->view("admin/lunch/lunch_menu", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data); //page load
	}

    public function get_menu_ajax($id)
	{   
		$this->db->where('id', $id);
		$result = $this->db->get('lunch_vendor_menu')->row();
		header('Content-Type: application/x-json; charset=utf-8');
		echo (json_encode($result));
	}
    public function menu_delete($id){
        //delete id
        $this->db->where('id', $id);
        $this->db->delete('lunch_vendor_menu');
        $this->session->set_flashdata('warning', 'Successfully Deleted');
        redirect('admin/lunch/lunch_menu');
    }



    public function vendor_data(){

        $date = $this->input->post('date');
        $totalMeal = $this->input->post('total_meal');
        $remarks = $this->input->post('remarks');
        $total_amount = $this->input->post('total_amount');
        $this->db->where('date', $date);
        $query = $this->db->get('lunch_vendor_meal');
        if (count($query->result()) > 0) {
                if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                    $prefile = $this->input->post('prefile');
                    $fileLocation=$prefile;
                    unlink($fileLocation);
                    $config['upload_path'] = 'uploads/vendor_file/'; // Specify the folder to upload files to
                    $config['allowed_types'] = 'pdf|jpg|jpeg|png'; // Specify the allowed file types
                    $config['max_size'] = 20048; // Specify the maximum file size in kilobytes
                    $this->load->library('upload', $config);
                
                    if (!$this->upload->do_upload('file')) {
                        // Handle file upload errors
                        $error = $this->upload->display_errors();
                        echo $error;
                    } else {
                        // File uploaded successfully
                        $data = $this->upload->data();
                        $fileExtension = pathinfo($data['file_name'], PATHINFO_EXTENSION);
                        $fileLocation = $config['upload_path'] . $date . '.' . $fileExtension;
                        $newFileName = $date . '.' . $fileExtension;
                
                        // Rename the uploaded file to include the date
                        rename($data['full_path'], $fileLocation);
                        $data = array(
                            'date' => $date,
                            'meal_qty' => $totalMeal,
                            'amount' => $total_amount,
                            'remarks' => $remarks,
                            'file' => $fileLocation,
                            'status' => 0,
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('date', $date);
                        $this->db->update('lunch_vendor_meal', $data);
                        echo "Successfully updated";
                    }
            
                }else{
                    $data = array(
                        'date' => $date,
                        'meal_qty' => $totalMeal,
                        'amount' => $total_amount,
                        'remarks' => $remarks,
                        'status' => 0,
            
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $this->db->where('date', $date);
                    $this->db->update('lunch_vendor_meal', $data);
                    echo "Successfully updated";

                

                }

        }  else {
        $config['upload_path'] = 'uploads/vendor_file/'; // Specify the folder to upload files to
        $config['allowed_types'] = 'pdf|jpg|jpeg|png'; // Specify the allowed file types
        $config['max_size'] = 2048; // Specify the maximum file size in kilobytes
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('file')) {
            // Handle file upload errors
            $error = $this->upload->display_errors();
            echo $error;
        } else {
            // File uploaded successfully
            $data = $this->upload->data();
            $fileExtension = pathinfo($data['file_name'], PATHINFO_EXTENSION);
            $fileLocation = $config['upload_path'] . $date . '.' . $fileExtension;
            $newFileName = $date . '.' . $fileExtension;
    
            // Rename the uploaded file to include the date
            rename($data['full_path'], $fileLocation);
            $data = array(
                'date' => $date,
                'meal_qty' => $totalMeal,
                'amount' => $total_amount,
                'remarks' => $remarks,
                'file' => $fileLocation,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('lunch_vendor_meal', $data);
            echo "Success";
        }
     }
    }
    public function edit_vendor_data(){
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('lunch_vendor_meal')->row();
        echo json_encode($query);
    }

    // ============================employee view==============================================
    public function lunch_emp_bill(){
        $session = $this->session->userdata('username');
		//  dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['session'] 			= $session;
		$data['title'] 			= 'Lunch | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Lunch';
		$data['subview'] 		= $this->load->view("admin/lunch/lunch_emp_bill", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data); 
    }
}
?>