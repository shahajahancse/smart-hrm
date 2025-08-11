<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Dashboard extends API_Controller
{
    public function __construct() {
        parent::__construct();  
        $this->load->helper('api_helper');   
        $this->load->model("Salary_model");
        $this->load->model("Lunch_model");
   
    }
    /**
     * demo method 
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    public function test()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);

        if ($user_info['status'] == true) {
            echo json_encode($user_info);
            exit();
        }else{
            echo json_encode($user_info);
            exit();
        }
    }

    /**
     * view method
     *
     * @link [api/user/view]
     * @method POST
     * @return Response|void
     */
    public function view()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }

    public function index(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;

            $punch_time = $this->db->select('clock_in, clock_out')
                        ->where('employee_id', $userid)
                        ->where('attendance_date', date('Y-m-d'))
                        ->get('xin_attendance_time')
                        ->row();
            if (!empty($punch_time)) {
                $data['date']=date('d-M-Y');
                if ($punch_time->clock_in) {
                    $data['in_time'] = date('h.i A', strtotime($punch_time->clock_in));
                }else {
                    $data['in_time'] = null;
                }
                if ($punch_time->clock_out) {
                    $data['out_time'] = date('h.i A', strtotime($punch_time->clock_out));
                }else{
                    $data['out_time'] = null;
                }
            }else{
                $data['date']=date('d-M-Y');
                $data['in_time'] = null;
                $data['out_time'] = null;
            }
            $data['employee_name'] = $this->db->select('first_name,last_name')
                ->where('user_id', $userid)
                ->get('xin_employees')
                ->row();
                $first_date = date('Y-m-01');
                $second_date = date('Y-m-d');
                $attendanceData = $this->db
                    ->select("COUNT(CASE WHEN status = 'present' THEN 1 END) AS count_p,
                               COUNT(CASE WHEN status = 'absent' THEN 1 END) AS count_a,
                               COUNT(CASE WHEN late_status = '1' THEN 1 END) AS count_late")
                    ->where('employee_id', $userid)
                    ->where("attendance_date BETWEEN '".$first_date."' AND '".$second_date."'")
                    ->get('xin_attendance_time')
                    ->row();
                $data['working_day']= $attendanceData->count_p;
                $data['absent'] = $attendanceData->count_a;
                $data['late_day'] = $attendanceData->count_late;

                $data['Salary_table'] = $this->Salary_model->getall_salary_with_idap_this_y($userid);
                // $leave_calel=get_cal_leave($userid, 1);
                // $leave_calsl=get_cal_leave($userid, 2);
                // $data['leave']=$leave_calel+$leave_calsl;
                $result = $this->db->order_by('id', 'desc')->get('lunch_payment', 1)->row();
                $lunch_data = $this->db
                                ->select('lunch_payment.*')
                                ->from('lunch_payment')
                                ->where('lunch_payment.end_date', $result->end_date)
                                ->where('lunch_payment.emp_id', $user_data->user_id)
                                ->order_by('lunch_payment.id', 'desc')
                                ->get()
                                ->result();
            $data1=$lunch_data[0];
            $current_month_lonch = $this->Lunch_model->get_data_date_wise($data1->end_date, $data1->next_date, $data1->emp_id);
            $taken_lunch=0;
            foreach ($current_month_lonch['emp_data'] as $r) {
                $taken_lunch+=$r->meal_amount;
            }
            $total_lunch = (int)$data1->probable_meal;
            $total_payment  =   $data1->pay_amount;
            $saved_lunch    =   $total_lunch-$taken_lunch;
            $data['total_lunch']    =   $total_lunch;
            $data['total_payment']  =   $total_payment;
            $data['saved_lunch']    =   $saved_lunch;
            $data['taken_lunch' ]   =   $taken_lunch;

            $le = cals_leave($userid, date('Y'));
            if (empty($le)) {
                $data['earn_total'] = '0';
                $data['sick_total'] ='0';
                $data['earn_leave'] = 0;
                $data['sick_leave'] = 0;
                $data['leave'] = 0;
            }else{
              $data['earn_total'] = strval($le->el_total);
              $data['sick_total'] = strval($le->sl_total);
              $data['earn_leave'] = floor($le->el_balanace);
              $data['sick_leave'] = floor($le->sl_balanace);
              $data['leave'] = floor($le->sl_balanace) + floor($le->el_balanace);
            }

            $data['Upcoming_holydays']= $this->db->select('*')->limit(5)->where("start_date > '".date('Y-m-d')."'")->get('xin_holidays')->result();
            $data['notice'] = $this->db->get('xin_events')->result();
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                    'data' => $data,
                ], 200);
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }
}