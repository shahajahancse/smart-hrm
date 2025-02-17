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

class Attendance extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $session = $this->session->userdata('username');
        // if(empty($session)) {
        //     redirect('admin/');
        // }
        //load the model
        $this->load->model('Attendance_model');
        $this->load->model("Xin_model");
        $this->load->model("Job_card_model");
        $this->load->model("Timesheet_model");
        $this->load->model("Salary_model");

        // $this->load->model("Employees_model");
        // $this->load->library('email');
        $this->load->model("Department_model");
        $this->load->model("Designation_model");
        // $this->load->model("Roles_model");
        // $this->load->model("Project_model");
        // $this->load->model("Location_model");
    }

    public function index()
    {

        $data['title'] = $this->lang->line('dashboard_attendance').' | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = $this->lang->line('dashboard_attendance');
        $data['path_url'] = 'attendance';
        // $data['all_office_shifts'] = $this->Location_model->all_office_locations();
        $data['subview'] = $this->load->view("admin/attendance/index", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load

    }
    // public function leave_all_cal()
    // {
    //     $this->Attendance_model->leave_cal_all();

    // }

    // public function attendance_process($process_date, $status)
    
    
    public function attendance_process()
    {
        // dd($sql);
        $process_date = $this->input->post('process_date');
        $status = $this->input->post('status');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        date("Y-m-d", strtotime($process_date));
        $this->db->trans_start();

        $process_date = date("Y-m-d", strtotime($process_date));
        $this->Attendance_model->attn_process($process_date, $emp_id);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            echo "Process failed";
        } else {
            echo "Process completed sucessfully";
        }

    }


    // public function attendance_process($process_date, $status)
    public function attn_process_auto()
    {
        exit('this function only for admin');
        $num_of_days = date("t", strtotime(date("Y-05")));
        $result = $this->db->select('user_id')->where_in('status', array(1,4,5))->get('xin_employees')->result();
        $emp_id = array();
        foreach ($result as $key => $value) {
            $emp_id[$key] = $value->user_id;
        }

        $process_date  = date("Y-05-01");
        for ($i=0; $i < $num_of_days; $i++) {
            $process_date = date("Y-m-d", strtotime("+1 day", strtotime($process_date)));
            echo "<pre> $process_date";
            $this->Attendance_model->attn_process($process_date, $emp_id);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            echo "Process failed";
        } else {
            echo "Process completed sucessfully";
        }

    }

    // manual entry system
    public function manual_attendance()
    {
        if (!empty($_POST)) {

            $date = $this->input->post('date');
            $in_time = $this->input->post('in_time');
            $out_time = $this->input->post('out_time');
            $reason = $this->input->post('reason');
            $location = $this->input->post('location');
            $project_name = $this->input->post('project_name');
            $contact_person = $this->input->post('contact_person');
            $status = $this->input->post('status');
            $sql = $this->input->post('sql');

            $emp_id = explode(',', trim($sql));

            if (count($emp_id)>1) {
                echo "Required to Punch Id of one employee at a time";
                exit;
            }

            $in_time = $in_time ? $date .' '. $in_time : '';
            $out_time = $out_time ? $date .' '. $out_time : '';

            // dd($in_time .' = '. $out_time);
            foreach ($emp_id as $key => $row) {
                $proxi_id = $this->db->where('emp_id', $row)->get('xin_proxi')->row()->proxi_id;
                if ($proxi_id == null) {
                    $name = $this->db->where('user_id', $row)->get('xin_employees')->row();

                    echo "Required to Punch Id of $name->first_name $name->last_name";
                    exit;
                } elseif ($proxi_id == ' ') {
                    $name = $this->db->where('user_id', $row)->get('xin_employees')->row();
                    echo "Required to Punch Id of $name->first_name $name->last_name";
                    exit;
                }
                $session = $this->session->userdata('username');

                if (in_array($session['role_id'], [2,3,4,5,6])) {
                    $employee_managment = $this->db->where('user_id', $row)->get('xin_employees')->row();
                    if ($employee_managment->is_management == 1) {
                        echo "You don't have permission to punch this employee $employee_managment->first_name  $employee_managment->last_name";
                        exit;
                    }
                    if ($status != '' && $status == 1) {
                        if($in_time != '' && $in_time <=date('Y-m-d H:i', strtotime('-72 hours'))) {
                            echo "You don't have permission to punch this employee $employee_managment->first_name  $employee_managment->last_name on this time";
                            exit;
                        }
                        if($out_time != '' && $out_time <=date('Y-m-d H:i', strtotime('-72 hours'))) {
                            echo "You don't have permission to punch this employee $employee_managment->first_name  $employee_managment->last_name on this time";
                            exit;
                        }
                    }else{

                        if($in_time != '' && $in_time <=date('Y-m-d H:i', strtotime('-3 day'))) {
                            echo "You don't have permission to punch this employee $employee_managment->first_name  $employee_managment->last_name on this time";
                            exit;
                        }
                        if($out_time != '' && $out_time <=date('Y-m-d H:i', strtotime('-3 day'))) {
                            echo "You don't have permission to punch this employee $employee_managment->first_name  $employee_managment->last_name on this time";
                            exit;
                        }
                    }
                }
                

                // insert in time
                if ($in_time != '') {
                    $this->db->where("proxi_id", $proxi_id);
                    $this->db->where("date_time", $in_time);
                    $query1 = $this->db->get("xin_att_machine");
                    $num_rows1 = $query1->num_rows();

                    if($num_rows1 == 0) {
                        $data = array(
                                'proxi_id' 	=> $proxi_id,
                                'date_time'	=> $in_time,
                                'device_id' => 0,
                            );
                        $this->db->insert("xin_att_machine", $data);
                    }
                }

                // insert out time
                if ($out_time != '') {
                    $this->db->where("proxi_id", $proxi_id);
                    $this->db->where("date_time", $out_time);
                    $query1 = $this->db->get("xin_att_machine");
                    $num_rows1 = $query1->num_rows();

                    if($num_rows1 == 0) {
                        $data = array(
                                'proxi_id' 	=> $proxi_id,
                                'date_time'	=> $out_time,
                                'device_id' => 0,
                            );
                        $this->db->insert("xin_att_machine", $data);
                    }
                }

                // movement register insert
                if ($status != '' && $status == 1) {
                    $this->db->where("employee_id", $row)->where("date", $date)->where("astatus", 1);
                    $query = $this->db->get("xin_employee_move_register");
                    $num_rows = $query->num_rows();

                    if($num_rows == 0) {
                        $comData = array(
                            'employee_id' => $row,
                            'date' 		  => $date,
                            'out_time'    => $out_time,
                            'in_time'     => $in_time,
                            'astatus' 	  => 1,
                            'reason'	  => $reason,
                            'place_adress'	  => $location,
                            'project_name'	  => $project_name,
                            'contact_person'	  => $contact_person,
                        );
                        $this->db->insert("xin_employee_move_register", $comData);

                    } else {
                        if ($out_time != '' && $in_time != '' && $reason != '') {
                            $comData = array(
                                'out_time'    => $out_time,
                                'in_time'     => $in_time,
                                'reason'	  => $reason,
                                'place_adress'	  => $location,
                                
                            );
                        } elseif ($in_time != '' && $out_time != '') {
                            $comData = array(
                                'out_time'    => $out_time,
                                'in_time'     => $in_time,
                            );
                        } elseif ($in_time != '' && $reason != '') {
                            $comData = array(
                                'in_time'     => $in_time,
                                'reason'	  => $reason,
                                'place_adress'	  => $location,
                            );
                        } elseif ($out_time != '' && $reason != '') {
                            $comData = array(
                                'out_time'    => $out_time,
                                'reason'	  => $reason,
                                'place_adress'	  => $location,
                            );
                        } elseif ($in_time != '') {
                            $comData = array(
                                'in_time'     => $in_time,
                            );
                        } elseif ($out_time != '') {
                            $comData = array(
                                'out_time'    => $out_time,
                            );
                        }
                        $this->db->where('id', $query->row()->id)->update('xin_employee_move_register', $comData);
                    }
                }
            }
            // attendance process
            $this->Attendance_model->attn_process($date, $emp_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo "failed";
                exit;
            } else {
                echo "Successfully";
                exit;
            }
        }
    }
    public function manually()
    {
        $this->load->view('admin/attendance/manually');
    }
    // movement register > attendance
    public function move_register($id = null)
    {
        // dd($id);

        if($id != null) {
            $data = $this->db->where('id', $id)->get('xin_employee_move_register')->row();
            $emplyeedata = $this->db->where('user_id', $data->employee_id)->get('xin_employees')->row();
            $array=[$data,$emplyeedata];
            echo json_encode($array);
            exit;
        }

        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }

        $data['title'] = 'move leave'.' | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Movement leave';
        $data['path_url'] = 'attendance';

        if ($session['role_id'] != 3) {
            $data['results'] = $this->Attendance_model->get_movement_register();
        } else {
            $data['results'] = $this->Attendance_model->get_movement_register($session['user_id']);
        }


        $data['subview'] = $this->load->view("admin/attendance/move_register", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load

    }



    public function create_move_register()
    {
        $session = $this->session->userdata('username');
        if (!empty($_POST)) {
            $out_time = $_POST['out_time'] ? $_POST['date'] .' '. $_POST['out_time'] : '';
            $in_time = $_POST['in_time'] ? $_POST['date'] .' '. $_POST['in_time'] : '';
            $selectedOption = $this->input->post('reason');
            $reason=$selectedOption;
            if ($selectedOption === 'other') {
                $reasondata = $this->input->post('otherInput');
                $data = array(
                    'title' => $reasondata
                );
                $this->db->insert('xin_employee_move_reason', $data);
                $insert_id = $this->db->insert_id();
                $reason=$insert_id;
            }
            $targetDate = new DateTime($out_time);
            // Get the current date and time
            $currentDate = new DateTime($in_time);
            // Calculate the time difference
            $timeDiff = $currentDate->diff($targetDate);
            $timeDifferenceFormatted=$timeDiff->format('%d day, %H:%i:%s');

            $comData = array(
                'employee_id' => $this->input->post('emp_id'),
                'date' 		  => $this->input->post('date'),
                'out_time'    => $out_time,
                'in_time'     => $in_time,
                'duration'     => $timeDifferenceFormatted,
                'request_amount' => 0,
                'payable_amount' => 0,
                'status' => 0,
                'osd_status' => 1,
                'location_status' => 1,
                'in_out' => 0,
                'place_adress' => '',
                'astatus'     => $session['role_id']==3 ? 1 : 2,
                'reason'	  => $reason,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if ($this->input->post('id') != null) {
                $comData = array(
                    'out_time'    => $out_time,
                    'in_time'     => $in_time,
                    'reason'	  => $reason,
                    'astatus'     => $session['role_id']==3 ? 1 : 2,
                );

                $this->db->where('id', $this->input->post('id'))->update('xin_employee_move_register', $comData);
                $move_id= $this->input->post('id');
            } else {
                $this->db->insert('xin_employee_move_register', $comData);
                $move_id = $this->db->insert_id();
            }

            $data = array(
                'move_id' => $move_id,
                'travel_with' =>'[]',
                'g_place' =>'[]',
                'g_transportation' =>'[]',
                'g_costing' =>'[]',
                'c_place' =>'[]',
                'c_transportation' =>'[]',
                'c_costing' =>'[]',
                'additional_cost' =>'0',
                'remark' =>'',
            );
            $this->db->insert("xin_employee_move_details", $data);

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $response = ['status' => 'success', 'message' => "failed"];
                echo json_encode($response);
                // exit;
            } else {
                if ($this->input->post('id') != null) {
                    $response = ['status' => 'success', 'message' => "Successfully Update Done"];
                } else {
                    $response = ['status' => 'success', 'message' => "Successfully Insert Done"];
                }
                echo json_encode($response);
                // exit;
            }
        }
        redirect(base_url('admin/attendance/move_register'));
    }

    public function delete_move_register($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('xin_employee_move_register');
        redirect(base_url('admin/attendance/move_register'));
    }


    //copy value input to another input field

    public function copy_value()
    {
        $request_amount = $this->input->post('request_amount');
        echo $request_amount;
    }





    // report section here
    // status wise daily report
    public function daily_report()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $late_status = $this->input->post('late_status');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['status']= $status;
        $data['late_status']= $late_status;
        if ($status == 'Present') {
            $status = array('Present', 'HalfDay');
        } else {
            $status = array($status);
        }
        $data["values"] = $this->Attendance_model->daily_report($attendance_date, $emp_id, $status, $late_status);
        $data["attendance_date"] = $attendance_date;

        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            // dd($data["values"]);
            $this->load->view('admin/attendance/daily_report', $data);
        }
    }
    public function floor_movement()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data["values"] = $this->Attendance_model->floor_movement($attendance_date, $emp_id);
        $data["attendance_date"] = $attendance_date;
        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            // dd($data["values"]);
            $this->load->view('admin/attendance/floor_movement', $data);
        }
    }
    public function latecomment()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['status']= $status;
        $data["values"] = $this->Attendance_model->latecomment($attendance_date, $emp_id);
        $data["attendance_date"] = $attendance_date;
        if(is_string($data["values"])) {
            echo json_encode(['error' => "Not Available"]);

        } else {
            echo json_encode($data);
            exit;
        }
    }
    public function add_latecomment()
    {
        $date = $this->input->post('date');
        $emp_id = $this->input->post('empi_id');
        $comment = $this->input->post('comment');
        foreach($emp_id as $key=>$user_id) {
            $data = array(
                'comment'       => $comment[$key],
            );

            $this->db->where('attendance_date', $date);
            $this->db->where('employee_id', $user_id);
            $this->db->update('xin_attendance_time', $data);
        }
        echo json_encode("Success");
        exit;
    }

    public function lunch_report()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $late_status = $this->input->post('late_status');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['status']= $status;
        $data["values"] = $this->Attendance_model->lunch_report($attendance_date, $emp_id, $status, $late_status);
        $data["attendance_date"] = $attendance_date;

        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            $this->load->view('admin/attendance/lunch/lunch_in_out', $data);
        }
    }

    // Early Out Report
    public function early_out_report()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['status']= $status;
        $data["values"] = $this->Attendance_model->early_out_report($attendance_date, $emp_id, $status);
        $data["attendance_date"] = $attendance_date;

        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            $this->load->view('admin/attendance/early_out', $data);
        }

    }

    public function movement_report()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['status']= $status;
        $data["values"] = $this->Attendance_model->movement_report($attendance_date, $emp_id);
        $data["attendance_date"] = $attendance_date;

        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            $this->load->view('admin/attendance/movement_report', $data);
        }

    }

    // job_card > timesheet
    // Job Card Report
    public function job_card()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['company_info'] = $this->Xin_model->get_company_info(1);
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
        // dd($data);
        echo $this->load->view("admin/attendance/job_card", $data, true);

    }
    public function get_job_card_emp()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $session = $this->session->userdata('username');
        //  dd($session['user_id']);
        if(empty($session)) {
            echo 'Session not found';
        }
        $session = $this->session->userdata('username');
        $emp_id  = [$session[ 'user_id' ]];
        


        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['company_info'] = $this->Xin_model->get_company_info(1);
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
        // dd($data);
        echo $this->load->view("admin/attendance/job_card", $data, true);

    }
    public function extra_present()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $sql = $this->input->post('sql');
        if (empty($sql)) {
            $emp_id = array();
        } else {
            $emp_id = explode(',', trim($sql));
        }

        $this->db->select('
        xin_employees.user_id as emp_id,
        xin_employees.employee_id,
        xin_employees.first_name,
        xin_employees.last_name,
        xin_employees.department_id,
        xin_employees.designation_id,
        xin_employees.date_of_joining,
        xin_departments.department_name,
        xin_designations.designation_name,
        xin_attendance_time.attendance_date,
        xin_attendance_time.clock_in,
        xin_attendance_time.clock_out,
        xin_attendance_time.attendance_status,
        xin_attendance_time.status,
        xin_attendance_time.late_status,
        xin_attendance_time.comment,
      ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');


        $this->db->where("xin_employees.is_active", 1);
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'" );
        if (!empty($emp_id)) {
            $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        }
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');

        $this->db->where_in("xin_attendance_time.attendance_status", 'Present');
        $this->db->where_in("xin_attendance_time.status", 'Off Day');


        $this->db->order_by('xin_attendance_time.employee_id', "ASC");
        

        $data["values"] = $this->db->get()->result();
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $this->load->view('admin/attendance/extra_present', $data);
        
    }
    public function overall_performance()
    {
        
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $sql = $this->input->post('sql');
        if (empty($sql)) {
            $emp_id = array();
        } else {
            $emp_id = explode(',', trim($sql));
        }
        $data=[];
        foreach($emp_id as $key => $value){
          $get_total_present = $this->Attendance_model->get_total_present($value, $first_date, $second_date);
          $get_total_absent = $this->Attendance_model->get_total_absent($value, $first_date, $second_date);
          $get_total_late = $this->Attendance_model->get_total_late($value, $first_date, $second_date);
          $get_total_overtime = $this->Attendance_model->get_total_overtime($value, $first_date, $second_date);
          $get_total_leave = $this->Attendance_model->get_total_leave($value, $first_date, $second_date);
        

          $total_day = $get_total_present + $get_total_absent+$get_total_leave;
          $get_percent_present = ($total_day != 0) ? ($get_total_present / $total_day) * 100 : 0;
          $get_percent_absent = ($total_day != 0) ? ($get_total_absent / $total_day) * 100 : 0;
          $get_percent_overtime = ($total_day != 0) ? ($get_total_overtime / $total_day) * 100 : 0;
          $get_percent_late = ($total_day != 0) ? ($get_total_late / $total_day) * 100 : 0;
          $get_percent_leave = ($total_day != 0) ? ($get_total_leave / $total_day) * 100 : 0;

          $get_employee_info= $this->Xin_model->read_user_info($value);
          $data[$key] = [
            'first_name' => $get_employee_info[0]->first_name,
            'last_name' => $get_employee_info[0]->last_name,
            'total_present' => $get_total_present,
            'total_percent_present' => number_format($get_percent_present, 2),
            'total_absent' => $get_total_absent,
            'total_percent_absent' => number_format($get_percent_absent, 2),
            'total_late' => $get_total_late,
            'total_percent_late' => number_format($get_percent_late, 2),
            'total_overtime' => $get_total_overtime,
            'total_percent_overtime' => number_format($get_percent_overtime, 2),
            'total_leave' => $get_total_leave,
            'total_percent_leave' => number_format($get_percent_leave, 2),
            'total_day' => $total_day,
          ];
        }
        $d['data']=$data;
        $d['first_date'] = $first_date;
        $d['second_date'] = $second_date;
        echo $this->load->view("admin/attendance/overall_performance", $d, true);

        
    }
    public function overall_performance_yearly()
    {
        $last_date = $this->input->post('first_date');
        $f_date = date('Y-01-01',strtotime($last_date));
        $year=date('Y',strtotime($f_date));
        $last_month=date('m',strtotime($last_date));

        $sql = $this->input->post('sql');
        if (empty($sql)) {
            $emp_id = array();
        } else {
            $emp_id = explode(',', trim($sql));
        }
        $data=[];
        foreach($emp_id as $key => $value){
            $employee_data_month=[];
            
        for($i=1;$i<=$last_month;$i++){
            $first_date = date("Y-m-01", strtotime("{$year}-{$i}-01"));
            $second_date = date("Y-m-t", strtotime("{$year}-{$i}-01"));
            $get_total_present = $this->Attendance_model->get_total_present($value, $first_date, $second_date);
            $get_total_absent = $this->Attendance_model->get_total_absent($value, $first_date, $second_date);
            $get_total_late = $this->Attendance_model->get_total_late($value, $first_date, $second_date);
            $get_total_overtime = $this->Attendance_model->get_total_overtime($value, $first_date, $second_date);
            $get_total_leave = $this->Attendance_model->get_total_leave($value, $first_date, $second_date);
            $total_day = $get_total_present + $get_total_absent+$get_total_leave;
            $employee_data_month[$i] = [
                'month' => date('F', strtotime($first_date)),
                'total_day' => $total_day,
                'total_present' => $get_total_present,
                'total_absent' => $get_total_absent,
                'total_late' => $get_total_late,
                'total_overtime' => $get_total_overtime,
                'total_leave' => $get_total_leave,
            ];
        }
        $get_employee_info= $this->Xin_model->read_user_info($value);

            $data[$key] = [
                'emp_id' => $value,
                'first_name' => $get_employee_info[0]->first_name,
                'last_name' => $get_employee_info[0]->last_name,
                'employee_data_month' => $employee_data_month
            ];
        }
        $d['data']=$data;
        $d['year'] = $year;
        echo $this->load->view("admin/attendance/overall_performance_yearly", $d, true);
    }
    // public function overall_performance_yearly()
    // {
        
    //     $last_date = $this->input->post('first_date');
    //     $f_date = date('Y-01-01',strtotime($last_date));
    //     $year=date('Y',strtotime($f_date));
    //     $last_month=date('m',strtotime($last_date));

    //     $sql = $this->input->post('sql');
    //     if (empty($sql)) {
    //         $emp_id = array();
    //     } else {
    //         $emp_id = explode(',', trim($sql));
    //     }
    //     $data=[];
    //     foreach($emp_id as $key => $value){
    //         $employee_data_month=[];
            
    //     for($i=1;$i<=$last_month;$i++){
    //         $first_date = $year.'-'.$i.'-01';
    //         $second_date = $year.'-'.$i.'-31';
    //         $get_total_present = $this->Attendance_model->get_total_present($value, $first_date, $second_date);
    //         $get_total_absent = $this->Attendance_model->get_total_absent($value, $first_date, $second_date);
    //         $get_total_late = $this->Attendance_model->get_total_late($value, $first_date, $second_date);
    //         $get_total_overtime = $this->Attendance_model->get_total_overtime($value, $first_date, $second_date);
    //         $get_total_leave = $this->Attendance_model->get_total_leave($value, $first_date, $second_date);
    //         $total_day = $get_total_present + $get_total_absent+$get_total_leave;
    //         $employee_data_month[$i] = [
    //             'month' => date('F', strtotime($first_date)),
    //             'total_day' => $total_day,
    //             'total_present' => $get_total_present,
    //             'total_absent' => $get_total_absent,
    //             'total_late' => $get_total_late,
    //             'total_overtime' => $get_total_overtime,
    //             'total_leave' => $get_total_leave,
    //         ];
    //     }
    //     $get_employee_info= $this->Xin_model->read_user_info($value);

    //         $data[$key] = [
    //             'emp_id' => $value,
    //             'first_name' => $get_employee_info[0]->first_name,
    //             'last_name' => $get_employee_info[0]->last_name,
    //             'employee_data_month' => $employee_data_month
    //         ];
    //     }
    // }
    public function late_details()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $type = $this->input->post('type');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['late_id'] = $emp_id;
        $data['type'] = $type;
        echo $this->load->view("admin/attendance/late_details", $data, true);
    }
    public function absent_details()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['company_info'] = $this->Xin_model->get_company_info(1);
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
        // dd($data);
        // echo $this->load->view("admin/attendance/job_card", $data, true);
        echo $this->load->view("admin/attendance/absent_details", $data, true);
    }
    public function nda_report()
    {
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $this->db->select('e.first_name, e.last_name, deg.designation_name, dep.department_name, e.nda_status, e.letter_status');
        $this->db->join('xin_departments as dep', 'e.department_id = dep.department_id');
        $this->db->join('xin_designations as deg', 'e.designation_id = deg.designation_id');
        $this->db->where_in('e.user_id', $emp_id);
        $data['emp_data'] = $this->db->get('xin_employees as e')->result();
        echo $this->load->view("admin/attendance/nda_report", $data, true);
    }
    public function overtime_details()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $minute = $this->input->post('minute');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['minute'] = $minute;
        $data['late_id'] = $emp_id;
        echo $this->load->view("admin/attendance/overtime_details", $data, true);
    }
    public function movment_status_report()
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        $statusC = $this->input->post('statusC');
        
        $data["values"] = $this->Attendance_model->movment_status_report($f1_date, $f2_date, $statusC);

        $data['statusC']= $statusC;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            echo $this->load->view("admin/attendance/movment_status_report", $data, true);
        }




    }


    public function movment_status_report_excel()
    {

        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        $statusC = $this->input->post('statusC');


        //    $sql = $this->input->post('sql');
        //    $emp_id = explode(',', trim($sql));

        $data["values"] = $this->Attendance_model->movment_status_report($f1_date, $f2_date, $statusC);


        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['statusC']= $statusC;
        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            echo $this->load->view("admin/attendance/movment_status_report_excel", $data, true);
        }



    }


    public function monthly_report()
    {
        $first_date = $this->input->post('first_date');

        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['sql'] = $sql;
        $data['xin_employees'] =  $this->Attendance_model->get_employee($emp_id);
        echo $this->load->view("admin/timesheet/monthly_report", $data, true);



    }
    public function leave_report()
    {
      
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');
        $stutus = $this->input->post('stutus');
        $data['sql']= $sql ;
        $data['stutus']= $stutus;


        $emp_id = explode(',', trim($sql));
        $stutuss = explode(',', trim($stutus));
        $data['stutuss'] = $stutuss;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['type'] = $this->input->post('type');
    	$salary_month = date("Y-m", strtotime($first_date));
        $data["salary_month"] = $salary_month;

        $data['xin_employees'] =  $this->Attendance_model->leaves($emp_id, $first_date, $second_date, $stutuss);
            if ($this->input->post('exl') == 1) {
                echo $this->load->view("admin/attendance/leave_report_xlx", $data, true);
            }else{
                echo $this->load->view("admin/attendance/leave_report", $data, true);
            }
    }
    public function monthly_report_excel()
    {
        $first_date = $this->input->post('first_date');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['xin_employees'] =  $this->Attendance_model->get_employee($emp_id);
        echo $this->load->view("admin/timesheet/excel_monthly_report", $data, true);
    }



    // apply for ta / da
    public function apply_for_ta_da()
    {

        $data = $this->Attendance_model->apply_for_ta_da($_POST['form_id'], $_POST['request_amount'], $_POST['short_details']);
        echo json_encode($data);
    }

    public function view_ta_da($id, $st)
    {
        $data['alld']= $this->Attendance_model->view_ta_da($id);
        $data['st']= $st;
        $data['modelcontectview'] = $this->load->view("admin/attendance/modelcontectview", $data, true);
        echo $data['modelcontectview'] ;
    }



    public function update_ta_da()
    {
        $data = $this->Attendance_model->update_ta_da($_POST['form_id'], $_POST['payable_amount'], $_POST['status']);
        echo json_encode($data);
    }


    public function modify_for_ta_da($id)
    {
        $data = $this->Attendance_model->modify_for_ta_da($id);
        echo json_encode($data);
        exit;
    }

    public function get_employee_ajax_request()
    {
        $status = $this->input->get('status');
        $salary_month= date("Y-m-01", strtotime($this->input->get('salary_month')));
        $data["employees"] = $this->Attendance_model->get_employee_ajax_request($status, $salary_month);
        echo json_encode($data);
    }
    public function changetada()
    {
        $status = $this->input->post('status');
        $payable_amount = $this->input->post('payable_amount');
        $moveid = $this->input->post('moveid');
        $return_comment=$this->input->post('return_comment');
        $data = array(
            'payable_amount' => $payable_amount,
            'status' => $status,
            'return_comment' => $return_comment,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $moveid);
        $this->db->update('xin_employee_move_register', $data);
        echo "Success";
    }
    // ========================================Employee view===========================================
    // attandancevied code here
    public function employee_attendance()
    {
        $session = $this->session->userdata('username');
        //  dd($session['user_id']);
        if(empty($session)) {
            redirect('admin/');
        }
        $session = $this->session->userdata('username');
        $userid  = $session[ 'user_id' ];
        $firstdate = $this->input->get('firstdate');
        $seconddate = $this->input->get('seconddate');

        $this->db->select("*");
        $this->db->where("employee_id", $userid);
        if ($firstdate!=null && $seconddate!=null) {
            $f1_date=date('Y-m-d', strtotime($firstdate));
            $f2_date=date('Y-m-d', strtotime($seconddate));
            $this->db->where("attendance_date BETWEEN '$f1_date' AND '$f2_date'");
            $this->db->order_by("attendance_date", "desc");
            $data['alldata']   = $this->db->get('xin_attendance_time')->result();
            $data['tablebody'] = $this->load->view("admin/attendance/employee_at_tbale_body", $data, true);
            echo $data['tablebody'] ;
        } else {
            
            $this->db->order_by("attendance_date", "desc");
            $data['alldata'] = $this->db->get('xin_attendance_time')->result();
            $data["todaylog"]    = $this->Attendance_model->gettodaylog(date("Y-m-d"), $session['user_id']);
            $data['shift']       = $this->db->where('office_shift_id', 1)->get('xin_office_shift')->row();

            $data['session']     = $session;
            $data['title'] 		 = 'Attendance | '.$this->Xin_model->site_title();
            $data['breadcrumbs'] = 'Attendance';
            $data['tablebody'] 	 = $this->load->view("admin/attendance/employee_at_tbale_body", $data, true);

            $data['subview'] 	 = $this->load->view("admin/attendance/employee_attandance", $data, true);
            $this->load->view('admin/layout/layout_main', $data);
        }
    }
    public function punch_request(){
        $punch_type=$this->input->post('punch_type');
        $p_date=$this->input->post('p_date');
        $p_time=$this->input->post('p_time');
        $session = $this->session->userdata('username');
        $user_id  = $session[ 'user_id' ];
        $proxi_id = $this->db->where('emp_id', $user_id)->get('xin_proxi')->row()->proxi_id;

        $sql = "CREATE TABLE IF NOT EXISTS `xin_employee_punch_request` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `employee_id` int(11) NOT NULL,
            `proxi_id` int(11) NOT NULL,
            `punch_type` varchar(255) NOT NULL,
            `p_date` date NOT NULL,
            `p_time` time NOT NULL,
            `status` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $this->db->query($sql);

        $data = array(
            'employee_id' => $session['user_id'],
            'proxi_id' => $proxi_id,
            'punch_type' => $punch_type,
            'p_date' => $p_date,
            'p_time' => $p_time,
            'status' => 0,
        );
        $this->db->insert('xin_employee_punch_request', $data);
        echo 'Success';
    }


    public function punch_request_list(){
        $session = $this->session->userdata('username');
        $userid  = $session[ 'user_id' ];
        $this->db->select("xin_employee_punch_request.*, xin_employees.first_name, xin_employees.last_name");
        $this->db->from('xin_employee_punch_request');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_employee_punch_request.employee_id');
        $this->db->order_by("id", "desc");
        $data['alldata'] = $this->db->get()->result();
        $data['breadcrumbs'] = 'Punch Request List';
        $data['title'] = 'Punch Request List | '.$this->Xin_model->site_title();

        $data['subview'] = $this->load->view("admin/attendance/punch_request_list", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }
    public function accept_request(){
        $id = $this->input->post('id');
        $data = array(
            'status' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('xin_employee_punch_request', $data);

        $r_data = $this->db->where('id', $id)->get('xin_employee_punch_request')->row();
        $date=$r_data->p_date;
        $in_time=$r_data->p_time;
        $time= $date .' '. $in_time;


        $this->db->where("proxi_id", $r_data->proxi_id);
        $this->db->where("date_time", $time);
        $query1 = $this->db->get("xin_att_machine");
        $num_rows1 = $query1->num_rows();
        if($num_rows1 == 0) {
            $data = array(
                    'proxi_id' 	=>  $r_data->proxi_id,
                    'date_time'	=> $time,
                    'device_id' => 0,
                );
            $this->db->insert("xin_att_machine", $data);
        }
        $this->Attendance_model->attn_process($date, $r_data->employee_id);
        echo 'Success';
    }

    public function reject_request(){
        $id = $this->input->post('id');
        $data = array(
            'status' => 2
        );
        $this->db->where('id', $id);
        $this->db->update('xin_employee_punch_request', $data);
        echo 'Success';
    }





    public function employee_movement($type = null)
    {
        if ($type == null) {
            $data = $this->employee_movement_flor();
        } elseif ($type == 1) {
            $data = $this->employee_movement_outside_office();
        } else {
            $data = $this->employee_movement_outside_dhaka();
        }
        // dd($data['alldata']);
        $this->load->view('admin/layout/layout_main', $data);
    }


    public function employee_movement_flor()
    {
        $session = $this->session->userdata('username');
        $userid  = $session[ 'user_id' ];
        $firstdate = $this->input->post('firstdate');
        $seconddate = $this->input->post('seconddate');
        $this->db->select('floor_status');
        $this->db->where('user_id', $userid);
        $data['empinfo']=$this->db->get('xin_employees')->row();
        $this->db->select('user_id, first_name,last_name');
        $this->db->where('floor_status !=', $data['empinfo']->floor_status);
        $this->db->where_in('user_role_id', array(2,3,4,5))->where_in('status', array(1,4,5,6));
        $data['emp_floor']=$this->db->get('xin_employees')->result();
        $this->db->select("xin_employee_floor_move.*");
        $this->db->where("user_id", $userid);
        if ($firstdate!=null && $seconddate!=null) {
            $f1_date=date('Y-m-d', strtotime($firstdate));
            $f2_date=date('Y-m-d', strtotime($seconddate));
            $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
            $this->db->order_by("date", "desc");
            $data['alldata']   = $this->db->get('xin_employee_floor_move')->result();
            $data['tablebody'] = $this->load->view("admin/attendance/employee_movement_flor_table", $data, true);
            echo $data['tablebody'] ;
        } else {
            $this->db->order_by("date", "desc");
            $data['alldata'] = $this->db->get('xin_employee_floor_move')->result();
            $data["todaylog"]    = $this->Attendance_model->today_floor_movement($session['user_id']);
            $data['session']     = $session;
            $data['title'] 		 = 'Floor Movements';
            $data['breadcrumbs'] = 'Floor Movements';
            $data['tablebody'] 	 = $this->load->view("admin/attendance/employee_movement_flor_table", $data, true);
            $data['subview'] 	 = $this->load->view("admin/attendance/employee_movement_flor", $data, true);
            return $data;
        }
    }
    public function employee_movement_outside_office()
    {
        $session = $this->session->userdata('username');
        $userid  = $session[ 'user_id' ];
        $location_status=1;
        $data['location_status'] = $location_status;
        $firstdate = $this->input->post('firstdate');
        $seconddate = $this->input->post('seconddate');
        // dd('qkjfgnmdfnjbfnzdjkb z');
        $this->db->select("em.*, mr.title as reason, pl.address as place");
        $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
        $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
        $this->db->where("employee_id", $userid);
        $this->db->where("location_status", 1);
        if ($firstdate!=null && $seconddate!=null) {
            $f1_date=date('Y-m-d', strtotime($firstdate));
            $f2_date=date('Y-m-d', strtotime($seconddate));
            $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
            $this->db->order_by("id", "desc");
            $data['alldata']   = $this->db->get('xin_employee_move_register as em')->result();
            $data['tablebody'] = $this->load->view("admin/attendance/employee_movement_outside_office_table", $data, true);
            echo $data['tablebody'] ;
            exit;
        } else {
            $this->db->order_by("id", "desc");
            $data['alldata'] = $this->db->get('xin_employee_move_register as em')->result();
            $data['session']     = $session;
            $data['title'] 		 = 'Outside Office Movements';
            $data['breadcrumbs'] = 'Outside Office Movements';
            $data['tablebody'] 	 = $this->load->view("admin/attendance/employee_movement_outside_office_table", $data, true);
            $data['subview'] 	 = $this->load->view("admin/attendance/employee_movement_outside_office", $data, true);
            return $data;
        }
    }
    public function employee_movement_outside_dhaka()
    {
        $session = $this->session->userdata('username');
        $userid  = $session[ 'user_id' ];
        $location_status=2;
        $data['location_status'] = $location_status;
        $firstdate = $this->input->post('firstdate');
        $seconddate = $this->input->post('seconddate');
        $this->db->select("em.*, mr.title as reason, pl.address as place");
        $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
        $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
        $this->db->where("employee_id", $userid);
        $this->db->where("location_status", $location_status);
        if ($firstdate!=null && $seconddate!=null) {
            $f1_date=date('Y-m-d', strtotime($firstdate));
            $f2_date=date('Y-m-d', strtotime($seconddate));
            $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
            $this->db->order_by("id", "desc");
            $data['alldata']   = $this->db->get('xin_employee_move_register as em')->result();
            $data['tablebody'] = $this->load->view("admin/attendance/employee_movement_outside_office_table", $data, true);
            echo $data['tablebody'] ;
        } else {
            $this->db->order_by("id", "desc");
            $data['alldata']   = $this->db->get('xin_employee_move_register as em')->result();
            $data['session']     = $session;
            $data['title'] 		 = 'Outside Office Movements';
            $data['breadcrumbs'] = 'Outside Office Movements';
            $data['tablebody'] 	 = $this->load->view("admin/attendance/employee_movement_outside_office_table", $data, true);
            $data['subview'] 	 = $this->load->view("admin/attendance/employee_movement_outside_office", $data, true);
            return $data;
        }
    }

    public function add_move_register()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $userid  = $session[ 'user_id' ];
        if($this->input->post('location_status')==2) {
            $osd_status=0;
        } else {
            $osd_status=1;
        }
        $selectedOption = $this->input->post('reason');
        $reason=$selectedOption;
        if ($selectedOption === 'other') {
            $reasondata = $this->input->post('otherInput');
            $data = array(
                'title' => $reasondata
            );
            $this->db->insert('xin_employee_move_reason', $data);
            $insert_id = $this->db->insert_id();
            $reason=$insert_id;
        }
        $data = array(
            'employee_id' => $userid,
            'date' => date('Y-m-d'),
            'out_time' => date('Y-m-d H:i:s'),
            'in_time' => date('Y-m-d H:i:s'),
            'duration' => '00:00:00',
            'request_amount' => 0,
            'payable_amount' => 0,
            'status' => 0,
            'astatus' => 1,
            'osd_status' => $osd_status,
            'reason' => $reason,
            'location_status' => $this->input->post('location_status'),
            'in_out' => 1,
            'place_adress' => $this->input->post('place_adress'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        );
        if($this->db->insert("xin_employee_move_register", $data)) {
            $this->session->set_flashdata('success', 'Check in Successfully');
        } else {
            $this->session->set_flashdata('error', 'Check in Unuccessfully');
        }
        redirect('admin/attendance/employee_movement/'.$this->input->post('location_status'));
    }
    public function checkout($s)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $userid  = $session[ 'user_id' ];
        $this->db->select("*");
        $this->db->where("employee_id", $userid);
        $this->db->where("location_status", $s);
        $this->db->order_by("id", "desc");
        $this->db->limit(1); // Limit the result to 1 row
        $alldata = $this->db->get('xin_employee_move_register')->row();
        $targetDate = new DateTime($alldata->out_time);
        // Get the current date and time
        $currentDate = new DateTime();
        // Calculate the time difference
        $timeDiff = $currentDate->diff($targetDate);
        $timeDifferenceFormatted=$timeDiff->format('%d day, %H:%i:%s');
        $data = array(
            'in_time' => date('Y-m-d H:i:s'),
            'duration' => $timeDifferenceFormatted,
            'in_out' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $alldata->id);
        $this->db->update('xin_employee_move_register', $data);
        $this->session->set_flashdata('success', 'Check Out Successfully');
        redirect('admin/attendance/employee_movement/'.$s);
    }

    public function ta_da_form($id)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $userid  = $session[ 'user_id' ];
        $data['move_id'] 		 = $id;
        $this->db->select("*");
        $this->db->where("move_id", $id);
        $movedata  = $this->db->get('xin_employee_move_details')->result();
        if (count($movedata) != 0) {
            $data['movedata'] = $movedata[0];
        }
        $this->db->select("*");
        $this->db->where("id", $id);
        $move  = $this->db->get('xin_employee_move_register')->row();
        $data['move'] = $move;
        
        $data['title'] 		 = 'Outside Office Movements Form';
        $data['breadcrumbs'] = 'Outside Office Movements Form';
        $data['subview'] 	 = $this->load->view("admin/attendance/ta_da_form", $data, true);
        $this->load->view('admin/layout/layout_main', $data);
    }
    public function add_ta_da()
    {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $userid = $session['user_id'];
        $this->load->library('upload');
        $move_id = $this->input->post('move_id');
        $gonig_way_place = json_encode($this->input->post('gonig_way_place'));
        $gonig_way_transport = json_encode($this->input->post('gonig_way_transport'));
        $gonig_way_costing = json_encode($this->input->post('gonig_way_costing'));
        $coming_way_place = json_encode($this->input->post('coming_way_place'));
        $coming_way_transport = json_encode($this->input->post('coming_way_transport'));
        $coming_way_costing = json_encode($this->input->post('coming_way_costing'));
        $additional_cost = $this->input->post('additional_cost');
        $remark = $this->input->post('remark');
        $total_cost=0;
        $goingcosrarray=$this->input->post('gonig_way_costing');
        $comingcostrarray=$this->input->post('coming_way_costing');
        foreach ($goingcosrarray as  $value) {
            $total_cost+=$value;
        };
        foreach ($comingcostrarray as  $v) {
            $total_cost+=$v;
        };
        $total_cost+=$additional_cost;
        $data1 = array(
            'request_amount' => $total_cost, // Add the file location to the data array
            'status' => 1
        );
        $this->db->where('id', $move_id);
        $this->db->update('xin_employee_move_register', $data1);
        // File Upload Configuration
        $config['upload_path'] = './uploads/move_file/'; // Modify this path as needed
        $config['allowed_types'] = 'gif|jpg|png|pdf'; // Add more allowed file types as needed
        $config['encrypt_name'] = true; // Generate a unique encrypted filename
        $config['max_size'] = 10048; // Set maximum file size in kilobytes (2MB in this case)
        $this->upload->initialize($config);
        if ($this->upload->do_upload('additional_invoice')) {
            // File uploaded successfully
            $fileData = $this->upload->data();
            $fileLocation = base_url('uploads/move_file/') . $fileData['file_name'];
            $data = array(
                'move_id' => $move_id,
                'g_place' => $gonig_way_place,
                'g_transportation' => $gonig_way_transport,
                'g_costing' => $gonig_way_costing,
                'c_place' => $coming_way_place,
                'c_transportation' => $coming_way_transport,
                'c_costing' => $coming_way_costing,
                'additional_cost' => $additional_cost,
                'remark' => $remark,
                'costing_invoice' => $fileLocation // Add the file location to the data array
            );
        } else {
            // File upload failed or no file was uploaded
            $data = array(
                'move_id' => $move_id,
                'g_place' => $gonig_way_place,
                'g_transportation' => $gonig_way_transport,
                'g_costing' => $gonig_way_costing,
                'c_place' => $coming_way_place,
                'c_transportation' => $coming_way_transport,
                'c_costing' => $coming_way_costing,
                'additional_cost' => $additional_cost,
                'remark' => $remark,
            );
        }
        // Update the database
        $this->db->select("*");
        $this->db->where("move_id", $move_id);
        $movedata  = $this->db->get('xin_employee_move_details')->result();
        if (count($movedata) != 0) {
            $this->db->where('move_id', $move_id);
            $this->db->update('xin_employee_move_details', $data);
        }
        $this->db->insert('xin_employee_move_details', $data);
        redirect('admin/attendance/employee_movement/1');
    }
    public function moveplace()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $userid  = $session[ 'user_id' ];
        $data['session']     = $session;
        $data['title'] 		 = 'Attendance | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Attendance';
        $data['employees'] = $this->Attendance_model->get_move_place();
        $data['subview'] 	 =  $this->load->view('admin/attendance/move_place', $data, true);
        $this->load->view('admin/layout/layout_main', $data);
    }
    public function get_moveplace_ajax()
    {
        // Assuming you have a model called 'Attendance_model'
        $this->load->model('Attendance_model');
        // Fetch employee data from the model (adjust the method name as per your model)
        $employees = $this->Attendance_model->get_move_place();
        // Prepare the response data
        $response = array('status' => 'success', 'employees' => $employees);
        // Return the response as JSON
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function manage_moveplace($action = null)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $userid  = $session[ 'user_id' ];
        $data['session']     = $session;
        $data['title'] 		 = 'Attendance | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Attendance';
        if ($action === 'add') {
            $data = array(
                'address' => $this->input->post('address'),
                'place_discreption' => $this->input->post('place_discreption'),
                'place_status' => $this->input->post('place_status')
            );
            $this->Attendance_model->add_move_place($data);
            echo json_encode(['status' => 'success']);
        } elseif ($action === 'update') {
            $data = array(
                'address' => $this->input->post('address'),
                'place_discreption' => $this->input->post('place_discreption'),
                'place_status' => $this->input->post('place_status')
            );
            $place_id = $this->input->post('place_id');
            $this->Attendance_model->update_move_place($place_id, $data);
            echo json_encode(['status' => 'success']);
        } elseif ($action === 'delete') {
            $place_id = $this->input->post('place_id');
            $this->Attendance_model->delete_move_place($place_id);
            echo json_encode(['status' => 'success']);
        } else {
            // Handle invalid action or show the view for other actions
            $data['employees'] = $this->Attendance_model->get_move_place();
            $data['subview'] 	 =  $this->load->view('admin/attendance/move_place', $data);
            $this->load->view('admin/layout/layout_main', $data);
        }
    }
    public function extra_present_approval(){
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $sql = $this->input->post('sql');
        $emp_id = explode(',', $sql);
      $this->db->select("xin_attendance_time.*, xin_employees.first_name, xin_employees.last_name,");
      $this->db->from("xin_attendance_time");
      $this->db->join("xin_employees", "xin_employees.user_id = xin_attendance_time.employee_id");
      $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
      $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
      $this->db->where("xin_attendance_time.status","Off Day");
      $this->db->where("xin_attendance_time.attendance_status", "Present");
      $this->db->order_by("xin_attendance_time.employee_id");
      $query = $this->db->get()->result();
      echo  json_encode($query);
    }
    public function extra_present_approval_press(){
        $data = array(
            'extra_ap' => $this->input->post('data')
        );
        $time_attendance_id = $this->input->post('time_attendance_id');
        $this->db->where('time_attendance_id', $time_attendance_id);
        $this->db->update('xin_attendance_time', $data);
        echo 'success';
    }

    public function firebase_testing(){
        $firebase_server_key = 'AIzaSyAocs5RyWdSwsPYKMAThQfwOAbyuaYXeVU';
        // Replace with the device's registration token
        $token = 'device_token_here';
        // Notification details
        $title = 'Test Notification';
        $body = 'This is a test notification';
        // Prepare data
        $data = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'id' => '1',
                'status' => 'done'
            ]
        ];

        // Set CURL request options
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = [
            'Authorization: key=' . $firebase_server_key,
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Send a request and get the response
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        // Print the response
        echo $result;
    }
}