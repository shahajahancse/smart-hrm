<?php
class Import extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}



	// //this code work to advance salary insert of 01-04-2023
	// function index(){
	// 	date_default_timezone_set('Asia/Dhaka');

	// 	$file_name = "import/salary.txt";

	// 	if (file_exists($file_name)){
	// 		$lines = file($file_name);
	// 		foreach(array_values($lines)  as $line) {
	// 			list($id, $amt) = preg_split('/\s+/', trim($line));
	// 			$data= array(
    //                 'grand_net_salary'      => $amt,
    //                 'other_payment'         => 0,
    //                 'total_other_payments'  => 0,
    //                 'modify_salary'         => 0,
    //                 'm_pay_day'             => 0,
    //             );
    //             $this->db->where('employee_id', $id);
    //             $this->db->where('salary_month', '2023-01');
    //             $this->db->update('xin_salary_payslips', $data);
	// 		}
	// 		echo "Upload successfully done";
	// 	} else {
	// 		echo "File not found";
	// 	}
	// }


	function index(){
		date_default_timezone_set('Asia/Dhaka');

		$file_name = "import/password.txt";

		if (file_exists($file_name)){
			$lines = file($file_name);
			foreach(array_values($lines)  as $line) {
				list($row, $id, $pass) = preg_split('/\s+/', trim($line));
				if ($id=='no') {
					continue;
				}
				$options = array('cost' => 12);
				$password_hash = password_hash($pass, PASSWORD_BCRYPT, $options);
				$data= array(
                    'password'      => $password_hash,
                );
                $this->db->where('user_id', $id);
                $this->db->update('xin_employees', $data);
			}
			echo "Upload successfully done";
		} else {
			echo "File not found";
		}
	}
	function entry_email(){
		date_default_timezone_set('Asia/Dhaka');

		$file_name = "import/test.txt";
		$imdata='';

		if (file_exists($file_name)){
			$lines = file($file_name);
			foreach(array_values($lines)  as $line) {
				list($row, $id, $email) = preg_split('/\s+/', trim($line));

				$data= array(
                    'email'      => $email,
                );
                $this->db->where('user_id', $id);
                $this->db->update('xin_employees', $data);

				$pass = $this->db->select('user_password')
				->from('xin_employees')
				->where('user_id', $id)->get()->row();

				if ($pass->user_password) {
					$imdata.= $row .' '. $pass->user_password .'<br>';
				}else{
					$imdata.= $row .' '. '-' .'<br>';
				}
			};

			dd($imdata);
			echo "Upload successfully done";
		} else {
			echo "File not found";
		}
	}


}

?>