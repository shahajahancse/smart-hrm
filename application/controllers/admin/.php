<?php
class Import extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		date_default_timezone_set('Asia/Dhaka');

		$file_name = "import/salary.txt";

		if (file_exists($file_name)){
			$lines = file($file_name);
			foreach(array_values($lines)  as $line) {
				list($id, $amt) = preg_split('/\s+/', trim($line));
				$data= array(
                    'grand_net_salary'      => $amt,
                    'other_payment'         => 0,
                    'total_other_payments'  => 0,
                    'modify_salary'         => 0,
                    'm_pay_day'             => 0,
                );
                $this->db->where('employee_id', $id);
                $this->db->where('salary_month', '2023-06');
                $this->db->update('xin_salary_payslips', $data);
			}
			echo "Upload successfully done";
		} else {
			echo "File not found";
		}
	}


}

?>