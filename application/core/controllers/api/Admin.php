<?php

// defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Admin extends API_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        // Allow methods: GET, POST, OPTIONS
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        // Allow header Content-Type: application/json
        header("Access-Control-Allow-Headers: Content-Type");
        
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("Timesheet_model");
        $this->load->model("Attendance_model");
        $this->load->model("Inventory_model");
        $this->load->model("Reports_model");
        $this->load->model("Lunch_model");
        $this->load->model("Xin_model");
        $this->load->model("Job_card_model");
        $this->load->library('upload');
    }

    public function get_device_token() {
        // dd($_POST);
        $punch_id=$_POST['data'];
        $this->db->where('proxi_id', $punch_id);
        $user=$this->db->get('xin_proxi')->row();
        if(!empty($user)) {
            $user_id=$user->emp_id;
            $this->db->where('user_id', $user_id);
            $api=$this->db->get('api_keys')->row();
            if (!empty($api)) {
                $device_id=$api->device_token;
                if (!empty($device_id)) {
                    $this->api_return($device_id, 200);
                }
            }
        }
    }
    public function sendRecentPunches() {

        $dataa=$_POST['data'];
        $emp_ids=[];
        foreach($dataa as $data) {
        $proxi_id=$data['id'];
        $time=$data['time'];
        $in_time=date('Y-m-d H:i:s', strtotime($time));
        $this->db->where("proxi_id", $proxi_id);
        $this->db->where("date_time", $in_time);
        $query1 = $this->db->get("xin_att_machine");
        $num_rows1 = $query1->num_rows();
        $emp_id=$this->db->select('emp_id')->where('proxi_id', $proxi_id)->get('xin_proxi')->row();
        // dd($emp_id->emp_id);
        if (!empty($emp_id)) {
            array_push($emp_ids, $emp_id->emp_id);
        }
        if($num_rows1 == 0) {
            $data = array(
                    'proxi_id' 	=> $proxi_id,
                    'date_time'	=> $in_time,
                    'device_id' => $data['state'],
                );
            $this->db->insert("xin_att_machine", $data);
        }
    }
    $this->Attendance_model->attn_process(date('Y-m-d', strtotime($in_time)), $emp_ids);
    }
    // leave
    public function leave_list()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $offset = $this->input->post('offset');
                $limit = $this->input->post('limit');
                $status = $this->input->post('status');

                $result = $this->Timesheet_model->get_leaves_with_info_with_pagi($offset, $limit, $status);
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function leave_list_date()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $start_date = $this->input->post('start_date');
                $end_date = $this->input->post('end_date');
                $status = $this->input->post('status');

                $result = $this->Timesheet_model->get_leaves_with_info_with_date($start_date, $end_date, $status);
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_leave_status()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $id = $this->input->post('leave_id');
                $data['result'] = $this->Timesheet_model->get_leaves_leave_id_with_info($id);
                if (empty($data['result'])) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }

                $year = date('Y', strtotime($data['result']->from_date));
                $leave_data_balance = cals_leave($data['result']->employee_id, $year);	
                if (empty($leave_data_balance)) {
                    $data['leave_totalel']=0;
                    $data['leave_totalsl']=0;
                    $data['leave_calel']=0;
                    $data['leave_calel_percent'] = 0;
                    $data['leave_calsl']=0;
                    $data['leave_calls_percent'] = 0;
                    $data['leave_calls_percent'] =0;
                }else{
                    $data['leave_totalel'] = floatval($leave_data_balance->el_total);
                    $data['leave_totalsl'] = floatval($leave_data_balance->sl_total);
                    $data['leave_calel'] = floatval($leave_data_balance->el_balanace);
                    if (floatval($leave_data_balance->el_total) != 0) {
                        $data['leave_calel_percent'] = (floatval($leave_data_balance->el_total) - floatval($leave_data_balance->el_balanace)) * 100 / floatval($leave_data_balance->el_total);
                    } else {
                        $data['leave_calel_percent'] = 0;
                    }
                    $data['leave_calsl'] = floatval($leave_data_balance->sl_balanace);
                    $data['leave_calls_percent'] = 0;
                    if (floatval($leave_data_balance->sl_total) != 0) {
                        $data['leave_calls_percent'] = (floatval($leave_data_balance->sl_total) - floatval($leave_data_balance->sl_balanace)) * 100 / floatval($leave_data_balance->sl_total);
                    }
                }
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Unauthorized User',
                        'data' => [],
                    ], 401);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_leave_status_change()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $total_days = $this->input->post('total_days');
                $status = $this->input->post('status');
                $remark = $this->input->post('remark');
                $leave_id = $this->input->post('leave_id');

                $hulfday = 0;
                if ($this->input->post('Half_Day')) {
                    $hulfday = 1;
                    $total_days = 0.5;
                }
                $qt_remarks = htmlspecialchars(addslashes($remark), ENT_QUOTES);
                $stutuss = $this->input->post('status');
                if ($stutuss == 4 || $stutuss == 3 || $stutuss == 2) {
                    $notyfi_data = 3;
                } else {
                    $notyfi_data = 1;
                };
                $qnty = $total_days;

                $data = array(
                    'status' => $status,
                    'remarks' => $qt_remarks,
                    'notify_leave' => $notyfi_data,
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'qty' => $qnty,
                    'is_half_day' => $hulfday,
                );
                $id = $this->input->post('leave_id');
                $result = $this->Timesheet_model->update_leave_record($data, $id);
                if ($result == true) {
                    if ($data['qty'] > 1) {
                        for ($i = 0; $i < $data['qty']; $i++) {
                            $process_date = date("Y-m-d", strtotime("+$i day", strtotime($data['from_date'])));
                            $this->Attendance_model->attn_process($process_date, array($_POST['emp_id']));
                        }
                    }else{
                        $process_date = $data['from_date'];
                        $this->Attendance_model->attn_process($process_date, array($_POST['emp_id']));
                    }
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'request failed',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    // levae end

    // stock in start
    public function stock_in_list()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $offset = $this->input->post('offset');
                $limit = $this->input->post('limit');
                $status = $this->input->post('status');
                $data['products'] = $this->Inventory_model->purchase_products_requisition_api($offset, $limit, $status);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_stock_in_details()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $id = $this->input->post('id');
                $data = $this->Inventory_model->product_requisition_details($id);
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_stock_in_status_change()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $id = $this->input->post('id');
                $quantity = $this->input->post('approved_quantity');
                $status = $this->input->post('status');
                if ($status == 1 || $status == 2 || $status == 4) {
                    $update = $this->db->where('id', $id)->update('products_purches_details', ['status' => $status, 'ap_quantity' => $quantity]);
                    if ($update) {
                        $this->api_return([
                            'status' => true,
                            'message' => 'Update Successful',
                            'data' => [],
                        ], 200);
                    } else {
                        $this->api_return([
                            'status' => false,
                            'message' => 'Update Failed',
                            'data' => [],
                        ], 200);
                    }
                } elseif ($status == 3) {

                    $results = $this->db->where('id', $id)->get('products_purches_details')->result();
                    foreach ($results as $key => $row) {
                        $product = $this->db->where('id', $row->product_id)->get('products')->row();
                        $quantity = $product->quantity + $row->ap_quantity;
                        $this->db->where('id', $row->product_id)->update('products', array('quantity' => $quantity));
                        $this->db->where('id', $row->id)->update('products_purches_details', array('status' => 3));
                    }
                    $deliver = $this->db->where('id', $id)->update('products_purches_details', ['status' => 3]);
                    if ($deliver) {
                        $this->api_return([
                            'status' => true,
                            'message' => 'Received Successful',
                            'data' => [],
                        ], 200);
                    } else {
                        $this->api_return([
                            'status' => false,
                            'message' => 'Update Failed',
                            'data' => [],
                        ], 200);
                    }
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please provide valid status',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    // stock in end

    // stock out start

    public function stock_out_list()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $offset = $this->input->post('offset');
                $limit = $this->input->post('limit');
                $status = $this->input->post('status');
                $data['products'] = $this->Inventory_model->product_requisition_api($offset, $limit, $status);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_stock_out_details()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $id = $this->input->post('id');
                $data['results'] = $this->Inventory_model->requisition_details($id);
                if (!empty($data['results'])) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_stock_out_status_change()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $id = $this->input->post('id');
                $quantity = $this->input->post('approved_quantity');
                $status = $this->input->post('status');
                $permission = $this->input->post('p_permission');

                $session = [
                    'role_id' => $user_info['user_info']->user_role_id,
                    'user_id' => $user_info['user_info']->user_id,
                ];
                if ($status == 4) {
                    $this->db->where('id', $id)->update('products_requisition_details', ['updated_by' => $user_info['user_info']->user_id]);
                    $approved = $this->db->where('id', $id)->update('products_requisition_details', ['status' => 4]);
                    if ($approved) {
                        $this->db->where('id', $id)->update('products_requisition_details', ['status' => 4]);
                        $this->api_return([
                            'status' => true,
                            'message' => 'successful',
                            'data' => [],
                        ], 200);
                    }
                } else {
                    $status = 1;
                    $approved_qty = $quantity;
                    $permission = $this->input->post('p_permission');
                    $r_id = $id;
                    //  manage permission to user wise
                    if ($session['role_id'] == 2) {
                        if ($permission == '0') {
                            $status = 2;
                        } else {
                            $status = 6;
                        }
                    } elseif ($session['role_id'] == 1) {
                        $status = 2;
                    } elseif ($session['role_id'] == 4) {
                        $status = 5;
                    } else {
                        $this->api_return([
                            'status' => false,
                            'message' => 'Please Give Valid status',
                            'data' => [],
                        ], 200);
                    }
                    $data = array(
                        'approved_qty' => $approved_qty,
                        'status' => $status,
                        'updated_by' => $session['user_id'],
                    );

                    $approved = $this->db->where('id', $r_id)->update('products_requisition_details', $data);
                    if ($approved) {
                        $this->api_return([
                            'status' => true,
                            'message' => 'Success',
                            'data' => [],
                        ], 200);
                    }
                }

            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }

    public function late_approved_list()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $salary_month = $this->db->select('*')->from('xin_salary_payslips')->order_by('payslip_id', 'DESC')->limit(1)->get()->row()->salary_month;
                $total_day= date('t', strtotime($salary_month));
                $month= date('m', strtotime($salary_month));
                $year= date('Y', strtotime($salary_month));
                $data= $this->Xin_model->modify_salary($salary_month);
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'total_day' => (int)$total_day,
                        'month' => (int)$month,
                        'year' => (int)$year,
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function late_approved_add()
    {
        
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $json_data = file_get_contents('php://input');

                // Decode the JSON data
                $data = json_decode($json_data, true);
                $date=$data['date'];
                $modify_data=$data['modify_data'];
               
                foreach ($modify_data as $key => $value) {
                    $user_id = $value['modify_user_id'];
                    $salary = $value['modify_salary'];
                    $date = $date;
                    $m_day = $value['modify_day'];
                    $result = $this->Xin_model->update_salaryall($user_id, $salary, $date, $m_day);
                    if ($result==false) {
                        $this->api_return([
                            'status' => false,
                            'message' => 'Unsuccessful',
                            'error'=>$this->db->error(),
                            'data' => [],
                        ], 200);
                        exit;
                    }
                }

             
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => [],
                    ], 200);
              
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function employee_report()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = $this->Reports_model->show_report();
            
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function device_report()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = $this->Reports_model->get_product_reports_info();
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function device_report_movement()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = $this->Reports_model->show_move_report( );
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function daily_payment_in()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $this->db->select('xin_project_invoice.*,xin_clients.name as client_name,xin_projects.title as project_name');
                $this->db->from('xin_project_invoice');
                $this->db->join('xin_clients', 'xin_clients.client_id = xin_project_invoice.clint_id');
                $this->db->join('xin_projects', 'xin_projects.project_id = xin_project_invoice.project_id');
                $this->db->where('xin_project_invoice.date',date('Y-m-d'));
                $data=$this->db->get()->result();
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function monthly_payment_in()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $this->db->select('xin_project_invoice.*,xin_clients.name as client_name,xin_projects.title as project_name');
                $this->db->from('xin_project_invoice');
                $this->db->join('xin_clients', 'xin_clients.client_id = xin_project_invoice.clint_id');
                $this->db->join('xin_projects', 'xin_projects.project_id = xin_project_invoice.project_id');
                $this->db->where('xin_project_invoice.date >=',date('Y-m-1'));
                $this->db->where('xin_project_invoice.date <=',date('Y-m-t'));
                $data=$this->db->get()->result();
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function daily_payment_out()
    { 
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $this->db->select('xin_payment_out_invoice.*,xin_payment_out_purpose.*');
                $this->db->from('xin_payment_out_invoice');
                $this->db->join('xin_payment_out_purpose', 'xin_payment_out_purpose.id = xin_payment_out_invoice.purposes');
                $this->db->where('xin_payment_out_invoice.date ',date('Y-m-d'));
                $data=$this->db->get()->result();
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function lunch_payment_report()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
               
                $data = $this->Lunch_model->paymentreport();
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function admin_dashboard()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                // present
                if(!$this->input->post('date')){
                    $this->api_return([
                        'status' => false,
                        'message' => 'Date Not Found',
                        'data' => [],
                    ], 200);
                    exit();
                }

                $first_date=date('Y-m-01',strtotime($this->input->post('date')));
                $second_date=date('Y-m-t',strtotime($this->input->post('date')));

                $upcoming_upgrade=[];
                $upcoming_increment=$this->Timesheet_model->upcomming_intrn_prob_promo($first_date,$second_date,1);
                $upcoming_intern=$this->Timesheet_model->upcomming_intrn_prob_promoo(null,null,4);
                $upcoming_probation=$this->Timesheet_model->upcomming_intrn_prob_promoo(null,null,5);

                $upcoming_upgrade['upcoming_increment']=($upcoming_increment==null)?0:count($upcoming_increment);
                $upcoming_upgrade['upcoming_intern']=($upcoming_intern==null)?0:count($upcoming_intern);
                $upcoming_upgrade['upcoming_probation']=($upcoming_probation==null)?0:count($upcoming_probation);

                $ldate =  date('Y-m-d',strtotime($this->input->post('date')));

                $this->db->select('lunch_details.*');
                $this->db->from('lunch_details');
                $this->db->where('lunch_details.date', $ldate);
                $this->db->where('lunch_details.meal_amount',1);
                $active_lunch= $this->db->get()->result();

                $this->db->select('lunch_details.*');
                $this->db->from('lunch_details');
                $this->db->where('lunch_details.date', $ldate);
                $this->db->where('lunch_details.meal_amount',0);
                $Inactive_lunch= $this->db->get()->result();
                
                $lunch=[];
                $lunch['active_lunch']=($active_lunch==null)?0:count($active_lunch);
                $lunch['Inactive_lunch']=($Inactive_lunch==null)?0:count($Inactive_lunch);



                $date=date('Y-m-d',strtotime($this->input->post('date')));
                $Present_status=[];
                $present=$this->Timesheet_model->get_today_present(0,'Present',$date);
                $Present_status['total_present']= count($present);
                $Present_status['present']=($present==null)?[]:$present;
                // Present end
                
                // absent
                $Absent_status=[];
                $absent=$this->Timesheet_model->get_today_present(0,'Absent',$date);
                $Absent_status['total_absent']= count($absent);
                $Absent_status['absent']=($absent==null)?[]:$absent;
                // absent end

                // late
                $Late_status=[];
                $late=$this->Timesheet_model->get_today_present(1,'Present',$date);
                $Late_status['total_late']= count($late);
                $Late_status['late']=($late==null)?[]:$late;
                // late end

                // Leave
                $leave_status=[];
                $leave=$this->Timesheet_model->get_today_leave($date);
                $leave_status['total_leave']= count($leave);
                $leave_status['leave']=($leave==null)?[]:$leave;
                // leave end
                $data['Present_status']=$Present_status;
                $data['Absent_status']=$Absent_status;
                $data['Late_status']=$Late_status;
                $data['leave_status']=$leave_status;
                $data['upcoming_upgrade']=$upcoming_upgrade;
                $data['lunch']=$lunch;
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'date' => $date,
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }


    // dashboard 2 work 
    public function admin_dashboard_2()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = [];

                $data['daily_date']=date('Y-m-d',strtotime($this->input->post('daily_date')));
                $data['daily_report']=$this->get_count($data['daily_date']);

                $data['monthly_date']=date('Y-m',strtotime($this->input->post('monthly_date')));
                $data['monthly_report']=$this->get_monthly_count($data['monthly_date']);
                                
                $data['requisition_first_date']=date('Y-m-d',strtotime($this->input->post('requisition_first_date')));
                $data['requisition_last_date']=date('Y-m-d',strtotime($this->input->post('requisition_last_date')));
                $data['requisition']=$this->get_requisition_count($data['requisition_first_date'],$data['requisition_last_date']);
                            
                $data['purchase_first_date']=date('Y-m-d',strtotime($this->input->post('purchase_first_date')));
                $data['purchase_last_date']=date('Y-m-d',strtotime($this->input->post('purchase_last_date')));
                $data['purchase']=$this->get_purchase_count($data['purchase_first_date'],$data['purchase_last_date']);
                                
                $data['payroll_first_date']=date('Y-m-d',strtotime($this->input->post('payroll_first_date')));
                $data['payroll_last_date']=date('Y-m-d',strtotime($this->input->post('payroll_last_date')));
                $data['payroll']=$this->get_payroll_count($data['payroll_first_date'],$data['payroll_last_date']);
                

                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
                
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function admin_dashboard_2_daily()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = [];
                $data['daily_date']=date('Y-m-d',strtotime($this->input->post('date')));
                $data['daily_report']=$this->get_count($data['daily_date']);
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
                
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function admin_dashboard_2_monthly()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = [];
                $data['monthly_date']=date('Y-m',strtotime($this->input->post('date')));
                $data['monthly_report']=$this->get_monthly_count($data['monthly_date']);
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
                
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function admin_dashboard_2_requisition()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = [];
                $data['requisition_first_date']=date('Y-m-d',strtotime($this->input->post('first_date')));
                $data['requisition_last_date']=date('Y-m-d',strtotime($this->input->post('last_date')));
                $data['requisition']=$this->get_requisition_count($data['requisition_first_date'],$data['requisition_last_date']);
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
                
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function admin_dashboard_2_purchase()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = [];
                $data['purchase_first_date']=date('Y-m-d',strtotime($this->input->post('first_date')));
                $data['purchase_last_date']=date('Y-m-d',strtotime($this->input->post('last_date')));
                $data['purchase']=$this->get_purchase_count($data['purchase_first_date'],$data['purchase_last_date']);
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
                
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function admin_dashboard_2_payroll()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $data = [];
               
                $data['payroll_first_date']=date('Y-m-d',strtotime($this->input->post('first_date')));
                $data['payroll_last_date']=date('Y-m-d',strtotime($this->input->post('last_date')));
                $data['payroll']=$this->get_payroll_count($data['payroll_first_date'],$data['payroll_last_date']);
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
                
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }

    public function get_count($date){
		$present=$this->Timesheet_model->get_today_present(0,'Present',$date);
		$absent=$this->Timesheet_model->get_today_present(0,'Absent',$date);
		$late=$this->Timesheet_model->get_today_present(1,'Present',$date);
		$leave=$this->Timesheet_model->get_today_leave($date);
		if ($leave==null) {
			$leave=[];
		}
		if ($late==null) {
			$late=[];
		}
		if ($absent==null) {
			$absent=[];
		}
		if ($present==null) {
			$present=[];
		}
		$data['absent']=$absent;
		$data['present']=$present;
		$data['late']=$late;
		$data['all_employees'] = array_merge($leave, $absent, $present);
		return $data;
	}
	public function daily_report()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $late_status = $this->input->post('late_status');
        $data['status']= $status;
        if ($status == 'Present') {
            $status = array('Present', 'HalfDay');
        } else {
            $status = array($status);
        }
        $data["values"] = $this->Attendance_model->daily_report($attendance_date, $emp_id = null, $status,$late_status);
        $data["attendance_date"] = $attendance_date;

        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            // dd($data["values"]);
            $this->load->view('admin/attendance/daily_report', $data);
        }
    }
	public function get_monthly_count($date){
		$first_date=date('Y-m-01', strtotime($date));
		$last_date=date('Y-m-t', strtotime($date));
		$leave=$this->Timesheet_model->get_leaves_with_info_with_date($first_date,$last_date);
		if ($leave==null) {
			$leave=[];
		}
		$extra_present=$this->Timesheet_model->extra_present_approval($first_date,$last_date);
		if ($extra_present==null) {
			$extra_present=[];
		}
		$late=$this->Attendance_model->get_total_late_monthly($first_date,$last_date);
		if ($late==null) {
			$late=[];
		}
		$meeting=$this->Attendance_model->get_total_meeting_monthly($first_date,$last_date);
		
		if ($meeting==null) {
			$meeting=[];
		}
		$data['leave']=$leave;
		$data['late']=$late;
		$data['meeting']=$meeting;
		$data['extra_present']=$extra_present;
        return $data;
	}
	public function get_payroll_count($first_date,$second_date){
	
		$emp_id=[];
		 $emp=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		 foreach($emp as $l){
			 if (!in_array($l->user_id, $emp_id)) {
				 $emp_id[] = $l->user_id;
			 }
		 }
		 $this->load->model('Reports_model');
		 $this->load->model('Lunch_model');
		$data['mobile_bill']=$this->Reports_model->show_mobile_bill_report($first_date,$second_date,$status=null,$emp_id);
		$statusC = 'all';
        $data["ta_da"] = $this->Attendance_model->movment_status_report($first_date, $second_date, $statusC);
		$data['lunch_paid']=$this->Lunch_model->paymentreport(1);
		$data['lunch_unpaid']=$this->Lunch_model->paymentreport(0);
        return $data;
	}
	public function get_requisition_count($first_date,$second_date){
	
        // dd($first_date .' = '. $second_date);
		 $a = $this->db->select('*')
		->where('requisition_date BETWEEN "'. $first_date . '" AND "'. $second_date .'"')
		->get('products_requisition_details')
		->result();
		$data['all_requisition'] = $a;
		$data['pending'] = [];
		$data['approved'] = [];
		$data['handover'] = [];
        foreach ($a as $key => $value) {
            if ($value->status == 1) {
                $data['pending'][] = $value;
            }
            if ($value->status == 2) {
                $data['approved'][] = $value;
            }
            if ($value->status == 3) {
                $data['handover'][] = $value;
            }
        }

        return $data;
	}
	public function get_purchase_count($first_date,$second_date){
	
        $a = $this->db->select('*')
        ->where("created_at BETWEEN '$first_date' AND '$second_date'")
        ->get('products_purches_details')
       ->result();
       $data['all_purchase'] = $a;
       $data['pending'] = [];
       $data['approved'] =[];
       $data['received'] =[];

       foreach ($a as $key => $value) {
           if ($value->status == 1) {
               $data['pending'][] = $value;
           }
           if ($value->status == 2) {
               $data['approved'][] = $value;
           }
           if ($value->status == 3) {
               $data['received'][] = $value;
           }
       }
       return $data;
   }
	public function get_leave_monthly()
	{
	   
		 $prossecc_date= $this->input->post('first_date');
		 $first_date = date('Y-m-01',strtotime($prossecc_date));
		 $second_date = date('Y-m-t',strtotime($prossecc_date));
	
		 $data['first_date'] = $first_date;
		 $data['second_date'] = $second_date;
		 $employee_id=[];
		 $leave=  $this->Attendance_model->leavesm($emp_id = null, $first_date, $second_date);
		 foreach($leave as $l){
			 if (!in_array($l->employee_id, $employee_id)) {
				 $employee_id[] = $l->employee_id;
			 }
		 }
		 $data['employee_id']=$employee_id;
		   echo $this->load->view("admin/reports/leave_report", $data, true);
	}
	public function get_extra_present_monthly()
	{
		 $prossecc_date= $this->input->post('first_date');
		 $first_date = date('Y-m-01',strtotime($prossecc_date));
		 $second_date = date('Y-m-t',strtotime($prossecc_date));
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

		 $this->db->where('xin_employees.department_id = xin_departments.department_id');
		 $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
		 $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
 
		 $this->db->where_in("xin_attendance_time.attendance_status", 'Present');
		 $this->db->where_in("xin_attendance_time.status", 'Off Day');
 
 
		 $this->db->order_by('xin_attendance_time.clock_in', "ASC");
		 $this->db->group_by('xin_attendance_time.employee_id');
		 
 
		 $data["values"] = $this->db->get()->result();
		 $data['first_date'] = $first_date;
		 $data['second_date'] = $second_date;
		 $this->load->view('admin/attendance/extra_present', $data);
	
	}
	public function get_late_monthly()
	{
		 $prossecc_date= $this->input->post('first_date');
		 $first_date = date('Y-m-01',strtotime($prossecc_date));
		 $second_date = date('Y-m-t',strtotime($prossecc_date));
		 $type = 1;
		 $data['first_date'] = $first_date;
		 $data['second_date'] = $second_date;
		 
		 $emp_id=[];
		 $leave=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		 foreach($leave as $l){
			 if (!in_array($l->user_id, $emp_id)) {
				 $emp_id[] = $l->user_id;
			 }
		 }
		 $data['late_id'] = $emp_id;
		 $data['type'] = $type;
		 echo $this->load->view("admin/attendance/late_details", $data, true);
		 
	
	}

	public function get_movment_monthly()
	{
		 $prossecc_date= $this->input->post('first_date');
		 $f1_date = date('Y-m-01',strtotime($prossecc_date));
		 $f2_date = date('Y-m-t',strtotime($prossecc_date));
		 $statusC = 'all';
        $data["values"] = $this->Attendance_model->movment_status_report($f1_date, $f2_date, $statusC);
        $data['statusC']= $statusC;
        $data['first_date'] = $f1_date;
        $data['second_date'] = $f2_date;
        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            echo $this->load->view("admin/attendance/movment_status_report", $data, true);
        }
		 
	
	}

	public function get_mobile_bill(){
		$first_date = $this->input->post('first_date');
		$second_date = $this->input->post('second_date');

		$emp_id=[];
		$leave=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		foreach($leave as $l){
			if (!in_array($l->user_id, $emp_id)) {
				$emp_id[] = $l->user_id;
			}
		}
        $data['first_date']  = $first_date; 
        $data['second_date'] = $second_date;
        $data['status'] 	 = 'All';
		$data['reports']     = $this->Reports_model->show_mobile_bill_report($first_date,$second_date,$status=null,$emp_id);
		$this->load->view('admin/reports/show_mobile_bill_report',$data);
	}
	public function get_ta_da(){
		$first_date = $this->input->post('first_date');
		$second_date = $this->input->post('second_date');

		$emp_id=[];
		$emp=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		foreach($emp as $l){
			if (!in_array($l->user_id, $emp_id)) {
				$emp_id[] = $l->user_id;
			}
		}


		
        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        $statusC = 'all';
        
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
	public function get_lunch_paid(){
		$status = 1;
        $data['status'] = $status;
        $data['lunch_data'] = $this->Lunch_model->paymentreport($status);
        $data['r'] = 'Payment';
        $this->load->view('admin/lunch/payment_report_page', $data);
	}
	public function get_lunch_unpaid(){
		$status = 0;
        $data['status'] = $status;
        $data['lunch_data'] = $this->Lunch_model->paymentreport($status);
        $data['r'] = 'Payment';
        $this->load->view('admin/lunch/payment_report_page', $data);
	}


    // dashboard 2 work end 






    public function attendence()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                // present
                if(!$this->input->post('date')){
                    $this->api_return([
                        'status' => false,
                        'message' => 'Date Not Found',
                        'data' => [],
                    ], 200);
                    exit();
                }
                $date=date('Y-m-d',strtotime($this->input->post('date')));
                
               


                $Present_status=[];
                $present=$this->Timesheet_model->get_today_present(null,'Present',$date);
                $Present_status['total_present']= count($present);
                $Present_status['present']=($present==null)?[]:$present;
                // Present end

                // absent
                $Absent_status=[];
                $absent=$this->Timesheet_model->get_today_present(0,'Absent',$date);
                $Absent_status['total_absent']= count($absent);
                $Absent_status['absent']=($absent==null)?[]:$absent;
                // absent end

               
                $Late_status=[];
                $late=$this->Timesheet_model->get_today_present(1,'Present',$date);
                $Late_status['total_late']= count($late);
                $Late_status['late']=($late==null)?[]:$late;
                // late end

                // Leave
                $leave_status=[];
                $leave=$this->Timesheet_model->get_today_leave($date);
                $leave_status['total_leave']= count($leave);
                $leave_status['leave']=($leave==null)?[]:$leave;
                // leave end
             


                $data['Present_status']=$Present_status;
                $data['Absent_status']=$Absent_status;
                $data['Late_status']=$Late_status;
                $data['leave_status']=$leave_status;
       
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'date' => $date,
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function upcomming_intrn_prob_promo()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                // present
                if(!$this->input->post('date')){
                    
                    $first_date=null;
                    $second_date=null;
                    
                    // $this->api_return([
                    //     'status' => false,
                    //     'message' => 'Date Not Found',
                    //     'data' => [],
                    // ], 200);
                    // exit();
                } else {
                    $first_date=date('Y-m-01',strtotime($this->input->post('date')));
                    $second_date=date('Y-m-t',strtotime($this->input->post('date')));
                }
                if(!$this->input->post('status')){
                    $this->api_return([
                        'status' => false,
                        'message' => 'Status Not Found',
                        'data' => [],
                    ], 200);
                    exit();
                }

               
                $status=$this->input->post('status');

                $data=$this->Timesheet_model->upcomming_intrn_prob_promoo($first_date,$second_date,$status);
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'date' => $this->input->post('date'),
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function done_intrn_prob_promo()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                // present
                if(!$this->input->post('date')){
                    $this->api_return([
                        'status' => false,
                        'message' => 'Date Not Found',
                        'data' => [],
                    ], 200);
                    exit();
                }
                $first_date=date('Y-m-01',strtotime($this->input->post('date')));
                $second_date=date('Y-m-t',strtotime($this->input->post('date')));
                $this->db->select('xin_employee_incre_prob.*,xin_employees.first_name,xin_employees.last_name,xin_employees.notify_incre_prob,xin_departments.department_name,xin_designations.designation_name');
                $this->db->from('xin_employee_incre_prob');
                $this->db->join('xin_employees', 'xin_employees.user_id = xin_employee_incre_prob.emp_id');
                $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
                $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
                $this->db->where('xin_employees.status', 1);
                $this->db->where('xin_employee_incre_prob.effective_date BETWEEN "'.$first_date.'" AND "'.$second_date.'"');
                $this->db->where('xin_employee_incre_prob.status',$this->input->post('status'));
                $this->db->order_by('xin_employees.basic_salary', 'asc');
                $data["employees"] = $this->db->get()->result();
                if (!empty($data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'date' => $this->input->post('date'),
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function lunch_order()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                // present
                if(!$this->input->post('date')){
                    $this->api_return([
                        'status' => false,
                        'message' => 'Date Not Found',
                        'data' => [],
                    ], 200);
                    exit();
                }
                $status=$this->input->post('status');
                if ($status == 1) {
                    $lunch_data=[];
                    $this->db->select('lunch.*');
                    $this->db->from('lunch');
                    $this->db->where('lunch.date', $this->input->post('date'));
                    $this->db->order_by('lunch.date', 'desc');
                    $lunch_data['lunch']= $this->db->get()->row();
                    if (!empty($lunch_data['lunch'])) {
                        $this->db->select('lunch_details.*,xin_employees.first_name,xin_employees.last_name,xin_departments.department_name,xin_designations.designation_name');
                        $this->db->from('lunch_details');
                        $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
                        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
                        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
                        $this->db->where('lunch_details.lunch_id', $lunch_data['lunch']->id);
                        $this->db->where('lunch_details.meal_amount',1);
                        $lunch_data['lunch_details'] = $this->db->get()->result();
                    }else{
                        $lunch_data['lunch_details'] =[];
                    }
                    $data = $lunch_data;
    
                }elseif($status == 2){
                        $ldate =  date('Y-m-d',strtotime($this->input->post('date')));
                        $this->db->select('lunch_details.*,xin_employees.first_name,xin_employees.last_name,xin_departments.department_name,xin_designations.designation_name');
                        $this->db->from('lunch_details');
                        $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
                        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
                        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
                        $this->db->where('lunch_details.date', $ldate);
                        $this->db->where('lunch_details.meal_amount',0);
                        $lunch_data['lunch_details'] = $this->db->get()->result();
                      $lunch_data['lunch']['emp_m'] = strval(count($lunch_data['lunch_details']));
                      $lunch_data['lunch']['guest_m'] = strval(0);
                        $data = $lunch_data;
                }
                if (!empty($data)) {
                    $this->api_return([      
                        'message' => 'successful',
                        'date' => $this->input->post('date'),
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }
    public function job_card(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $emp_id=$this->input->post('emp_id');
                if (empty($emp_id)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Employee',
                        'data' => $result,
                    ], 200);
                    exit;
                }
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => $result,
                    ], 200);
                    exit;
                }
                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => $result,
                    ], 200);
                    exit;
                }
                $result = $this->Reports_model->get_job_card($emp_id, $first_date, $second_date);
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function extra_present(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => $result,
                    ], 200);
                    exit;
                }
                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => $result,
                    ], 200);
                    exit;
                }
                $result = $this->Reports_model->get_extra_present($first_date, $second_date);
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_extra_present_approval(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                
                $time_attendance_id = $this->input->post('time_attendance_id');
                $extra_ap = $this->input->post('extra_ap');

                $this->db->where('time_attendance_id', $time_attendance_id);
                if ($this->db->update('xin_attendance_time', ['extra_ap' => $extra_ap])) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' =>[],
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
        
    }
    public function leave_report(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $emp_id=$this->input->post('emp_id');
                if (empty($emp_id)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Employee',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $emp_id=explode(",",$emp_id);

                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $status = $this->input->post('status');
                if (empty($status)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Status',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $result = $this->Reports_model->get_leave_report($emp_id, $first_date, $second_date, $status);
               
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function attendence_report(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $emp_id=$this->input->post('emp_id');
                if (empty($emp_id)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Employee',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $emp_id=explode(",",$emp_id);

                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $status = $this->input->post('status');
                if (empty($status)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select  Status',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $result = $this->Reports_model->get_attendence_report($emp_id, $first_date, $second_date, $status);
               
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function requisition_report(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $status = $this->input->post('status');
                if (empty($status)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select  Status',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $result = $this->Reports_model->get_requisition_report($first_date, $second_date, $status);
               
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function purchase_report(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $status = $this->input->post('status');
                if (empty($status)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select  Status',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $result = $this->Reports_model->get_store_in_report($first_date, $second_date, $status);
               
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function store_in_out_report(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $status = $this->input->post('status');
                if (empty($status)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select  Status',
                        'data' => [],
                    ], 200);
                    exit;
                }


                if ($status == 'in') {
                    $result = $this->Reports_model->get_store_in_report($first_date, $second_date);
                }elseif ($status == 'out') {
                    $result = $this->Reports_model->get_store_out_report($first_date, $second_date);
                }else{
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select valid status',
                        'data' => [],
                    ], 200);
                    exit;
                }
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function get_category(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $categories =$this->db->select('id,cat_name')->get('product_accessory_categories')->result(); 
                if ($categories) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $categories,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    
    public function inventory_report(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $status = $this->input->post('status');
                if (empty($status)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select status',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $result = $this->Reports_model->get_product_reports_info_2($status);

                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function vendor_daily_lunch(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $date = $this->input->post('date');
                if (empty($date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select  Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $result=$this->db->where('date',$date)->get('lunch_vendor_meal')->row();
                if (empty($result)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                    exit;
                }
              $result->file =  base_url($result->file);
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $categories,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function vendor_month_lunch(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $result=$this->db->where('date BETWEEN "'.$first_date.'" AND "'.$second_date.'"')->get('lunch_vendor_meal')->result();
                if (empty($result)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                    exit;}
                foreach ($result as $key => $value) {
                    $result[$key]->file =  base_url($value->file);
                }
                if ($result) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $result,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function increment_pending_done(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }

                $second_date = $this->input->post('second_date');
                if (empty($second_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Second Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $data['pending_list'] =$this->Reports_model->all_pending_report($emp_id=null, $first_date, $second_date);
		        $data['done_list'] =$this->Reports_model->all_done_report($emp_id=null, $first_date, $second_date);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User, Access Only Admin', 
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function leave_report_monthly_all_employee(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $data=$this->Reports_model->leave_report_monthly_all_employee($first_date);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User, Access Only Admin', 
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function leave_report_monthly_single_employee(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $employee_id = $this->input->post('employee_id');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Employee',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $data=$this->Reports_model->leave_report_monthly_single_employee($employee_id,$first_date);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User, Access Only Admin', 
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }  
    public function leave_report_yearly_all_employee(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $data=$this->Reports_model->leave_report_yearly_all_employee($first_date);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User, Access Only Admin', 
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function leave_report_yearly_single_employee(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($user_info['user_info']->user_role_id != 3) {
                $first_date = $this->input->post('first_date');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select First Date',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $employee_id = $this->input->post('employee_id');
                if (empty($first_date)) {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Please select Employee',
                        'data' => [],
                    ], 200);
                    exit;
                }
                $data=$this->Reports_model->leave_report_yearly_single_employee($employee_id,$first_date);
                if ($data) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                        'data' => $data,
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Data not found',
                        'data' => [],
                    ], 200);
                }
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User, Access Only Admin', 
                    'data' => [],
                ], 401);
            };
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
}