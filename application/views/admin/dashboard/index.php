<?php 
	$session = $this->session->userdata('username');
	$user_info = $this->Xin_model->read_user_info($session['user_id']);
	$theme = $this->Xin_model->read_theme_info(1);
?>
<?php
	if(in_array($user_info[0]->user_role_id, array(1,2,4,5,6,99))):

$dd='dashboard_3';

		if($dd == 'dashboard_1') {
			$this->load->view('admin/dashboard/administrator_dashboard_1');
		} else if($dd == 'dashboard_2') {
			$this->load->view('admin/dashboard/administrator_dashboard_2');
		} else if($dd == 'dashboard_3') {
			$this->load->view('admin/dashboard/administrator_dashboard_3');
		} else if($dd == 'dashboard_4') {
			$this->load->view('admin/dashboard/administrator_dashboard_4');
		} else {
			$this->load->view('admin/dashboard/administrator_dashboard_1');
		}
	/*elseif($user_info[0]->user_role_id==3):
		$this->load->view('admin/dashboard/management_dashboard');*/
	else:
		$this->load->view('admin/dashboard/employee_dashboard');
	endif;
?>











