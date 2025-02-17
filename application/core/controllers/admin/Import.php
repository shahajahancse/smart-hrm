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
			dd($lines);
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
function add_desktopss(){
    date_default_timezone_set('Asia/Dhaka');

    $file_name = "import/desktop.txt";

    if (file_exists($file_name)){
        $lines = file($file_name);
        foreach(array_values($lines)  as $line) {
            $data = array();
            $columns = preg_split('/\s+/', trim($line));
            if (count($columns) >= 12) { // Ensure at least 12 columns are present
                list($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l) = $columns;
                $data= array(
					// 'id' 		   => @$i+1,
                    'user_id'      => $a,
                    'desk_no'      => $b,
                    'device_type'  => $c,
                    'laptop_no'    => $d,
                    'ex_monitor_no'=> $e,
                    'configuration'=> $f,
                    'harddisk'     => $g,
                    'ssd'          => $h,
                    'ram'          => $i,
                    'keyboard'     => $j,
                    'mouse'        => $k,
                    'charger'      => $l,
                    'status'       => 2,
                    'created_at'   => date('Y-m-d H:i:s'),
                );
            } else {
                // Handle the case where the line doesn't have enough columns
                echo "Invalid line: $line";
                continue; // Skip to the next line
            }
            $this->db->insert('xin_emp_laptop', $data);
        }
        echo "Upload successfully done";
    } else {
        echo "File not found";
    }
}



	// function add_desktop(){
	// 	date_default_timezone_set('Asia/Dhaka');

	// 	$file_name = "import/desktop.txt";

	// 	if (file_exists($file_name)){
	// 		$lines = file($file_name);
	// 		foreach(array_values($lines)  as $line) {
	// 			list($row, $id, $pass) = preg_split('/\s+/', trim($line));
	// 			if ($id=='no') {
	// 				continue;
	// 			}
	// 			$options = array('cost' => 12);
	// 			$password_hash = password_hash($pass, PASSWORD_BCRYPT, $options);
	// 			$data= array(
    //                 'password'      => $password_hash,
    //             );
    //             $this->db->where('user_id', $id);
    //             $this->db->update('xin_employees', $data);
	// 		}
	// 		echo "Upload successfully done";
	// 	} else {
	// 		echo "File not found";
	// 	}
	// }


}

?>