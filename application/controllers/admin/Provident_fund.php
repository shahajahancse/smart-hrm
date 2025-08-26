<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provident_fund extends MY_Controller {

	public function __construct() {
        parent::__construct();
        //load the model
        $this->load->model("Provident_fund_model");
        $this->load->model("Xin_model");
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }

	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

    public function index() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Provident Fund Settings';
        $data['breadcrumbs'] = 'Provident Fund Settings';
        $data['path_url'] = 'provident_fund';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'pf_settings_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

        if(!empty($session)){
			$return = array('success'=>'', 'error'=>'', 'csrf_hash'=>'');
			$return['csrf_hash'] = $this->security->get_csrf_hash();

            $this->load->library('form_validation');
            $company_id = $this->Xin_model->get_company_id_of_current_user($session['user_id']); // Assuming this function exists

            if ($this->input->post('type') === 'add_edit_settings') {
                $this->form_validation->set_rules('employee_contribution_rate', 'Employee Contribution Rate', 'required|numeric');
                $this->form_validation->set_rules('employer_contribution_rate', 'Company Contribution Rate', 'required|numeric');
                $this->form_validation->set_rules('bank_interest_rate', 'Bank Interest Rate', 'required|numeric');
                $this->form_validation->set_rules('min_service_period_withdrawal', 'Min Service Period for Withdrawal', 'required|integer');
                $this->form_validation->set_rules('min_service_period_loan', 'Min Service Period for Loan', 'required|integer');

                if ($this->form_validation->run() == FALSE) {
                    $return['error'] = $this->form_validation->error_array();
                    $this->output($return);
                    exit;
                }

                $data_settings = array(
                    'employee_contribution_rate' => $this->input->post('employee_contribution_rate'),
                    'employer_contribution_rate' => $this->input->post('employer_contribution_rate'),
                    'bank_interest_rate' => $this->input->post('bank_interest_rate'),
                    'min_service_period_withdrawal' => $this->input->post('min_service_period_withdrawal'),
                    'min_service_period_loan' => $this->input->post('min_service_period_loan')
                );

                $existing_settings = $this->Provident_fund_model->get_pf_settings($company_id);
                if ($existing_settings) {
                    $result = $this->Provident_fund_model->update_pf_settings($company_id, $data_settings);
                    if ($result) {
                        $return['success'] = 'Provident Fund Settings updated successfully.';
                    } else {
                        $return['error'] = 'Failed to update Provident Fund Settings.';
                    }
                } else {
                    $data_settings['company_id'] = $company_id;
                    $result = $this->Provident_fund_model->add_pf_settings($data_settings);
                    if ($result) {
                        $return['success'] = 'Provident Fund Settings added successfully.';
                    } else {
                        $return['error'] = 'Failed to add Provident Fund Settings.';
                    }
                }
                $this->output($return);
                exit;
            }

            $data['pf_settings'] = $this->Provident_fund_model->get_pf_settings($company_id);
            $data['subview'] = $this->load->view("admin/provident_fund/pf_settings", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }

    // Add other functions for PF Settings, Employees, Contributions, etc. here
    public function employee_list() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Employee Provident Fund Accounts';
        $data['breadcrumbs'] = 'Employee Provident Fund Accounts';
        $data['path_url'] = 'provident_fund/employee_list';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'employee_list_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

        if(!empty($session)){
            $data['all_employees'] = $this->Xin_model->get_employees(); // Assuming this function exists and returns all employees
            $data['pf_accounts'] = $this->Provident_fund_model->get_all_employee_pf_accounts();
            $data['subview'] = $this->load->view("admin/provident_fund/employee_list", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }

    public function monthly_contributions() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Monthly Contributions';
        $data['breadcrumbs'] = 'Monthly Contributions';
        $data['path_url'] = 'provident_fund/monthly_contributions';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'monthly_contributions_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

            if(!empty($session)){
                $data['all_employees'] = $this->Xin_model->get_employees(); // Assuming this function exists
                $data['pf_accounts'] = $this->Provident_fund_model->get_all_employee_pf_accounts();
                $data['contributions'] = $this->Provident_fund_model->get_all_contributions();
                $data['subview'] = $this->load->view("admin/provident_fund/monthly_contributions", $data, TRUE);
                $this->load->view('admin/layout/layout_main', $data); //page load
            } else {
                redirect('admin/');
            }

    }

    public function yearly_reports() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Yearly Reports & Interest Calculation';
        $data['breadcrumbs'] = 'Yearly Reports & Interest Calculation';
        $data['path_url'] = 'provident_fund/yearly_reports';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'yearly_reports_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

            if(!empty($session)){
                $this->load->library('form_validation');

                if ($this->input->post('type') === 'calculate_interest') {
                    $year = $this->input->post('year');
                    if (empty($year)) {
                        $return['error'] = 'Please select a year.';
                        $this->output->set_content_type('application/json')->set_output(json_encode($return));
                        exit();
                    }
                    $result = $this->Provident_fund_model->calculate_and_post_interest($year);
                    if ($result !== false) {
                        $return['success'] = 'Interest calculated and posted for ' . $result . ' accounts.';
                    } else {
                        $return['error'] = 'Failed to calculate and post interest. Check PF settings.';
                    }
                    $this->output->set_content_type('application/json')->set_output(json_encode($return));
                    exit();
                }

                $data['yearly_interests'] = $this->Provident_fund_model->get_yearly_interest_report(date('Y')); // Default to current year
                $data['subview'] = $this->load->view("admin/provident_fund/yearly_reports", $data, TRUE);
                $this->load->view('admin/layout/layout_main', $data); //page load
            } else {
                redirect('admin/');
            }

    }

    public function withdrawal_requests() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Provident Fund Withdrawal Requests';
        $data['breadcrumbs'] = 'Provident Fund Withdrawal Requests';
        $data['path_url'] = 'provident_fund/withdrawal_requests';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'withdrawal_requests_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

            if(!empty($session)){
                $data['all_employees'] = $this->Xin_model->get_employees(); // Assuming this function exists
                $data['withdrawals'] = $this->Provident_fund_model->get_all_withdrawals();
                $data['subview'] = $this->load->view("admin/provident_fund/withdrawal_requests", $data, TRUE);
                $this->load->view('admin/layout/layout_main', $data); //page load
            } else {
                redirect('admin/');
            }

    }

    public function loan_applications() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Provident Fund Loan Applications';
        $data['breadcrumbs'] = 'Provident Fund Loan Applications';
        $data['path_url'] = 'provident_fund/loan_applications';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'loan_applications_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

            if(!empty($session)){
                $data['all_employees'] = $this->Xin_model->get_employees(); // Assuming this function exists
                $data['loans'] = $this->Provident_fund_model->get_all_loans();
                $data['subview'] = $this->load->view("admin/provident_fund/loan_applications", $data, TRUE);
                $this->load->view('admin/layout/layout_main', $data); //page load
            } else {
                redirect('admin/');
            }

    }

    public function reports() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Provident Fund Reports & Analytics';
        $data['breadcrumbs'] = 'Provident Fund Reports & Analytics';
        $data['path_url'] = 'provident_fund/reports';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'pf_reports_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

            if(!empty($session)){
                $data['all_employees'] = $this->Xin_model->get_employees(); // Assuming this function exists
                $data['pf_accounts'] = $this->Provident_fund_model->get_all_employee_pf_accounts();
                $data['pf_accounts'] = $this->Provident_fund_model->get_all_employee_pf_accounts();
                $data['contributions'] = $this->Provident_fund_model->get_all_contributions();
                $data['withdrawals'] = $this->Provident_fund_model->get_all_withdrawals();
                $data['loans'] = $this->Provident_fund_model->get_all_loans();
                $data['subview'] = $this->load->view("admin/provident_fund/reports", $data, TRUE);
                $this->load->view('admin/layout/layout_main', $data); //page load
            } else {
                redirect('admin/');
            }

    }

    public function generate_pf_statement() {
        $session = $this->session->userdata('username');
        if(empty($session)){
            redirect('admin/');
        }
        $data['title'] = 'Generate Provident Fund Statement';
        $data['breadcrumbs'] = 'Generate Provident Fund Statement';
        $data['path_url'] = 'provident_fund/generate_pf_statement';
        $data['arr_mod'] = array('provident_fund_open' => 'active', 'pf_statement_active' => 'active');
        $role_resources_ids = $this->Xin_model->user_role_resource();

            if(!empty($session)){
                // You might need to pass specific employee ID or date range for the statement
                // For now, let's assume it fetches all necessary data for a general statement
                $data['all_employees'] = $this->Xin_model->get_employees();
                $data['pf_accounts'] = $this->Provident_fund_model->get_all_employee_pf_accounts();
                $data['contributions'] = $this->Provident_fund_model->get_all_contributions();
                $data['withdrawals'] = $this->Provident_fund_model->get_all_withdrawals();
                $data['loans'] = $this->Provident_fund_model->get_all_loans();
                $data['subview'] = $this->load->view("admin/provident_fund/pf_statement_report", $data, TRUE);
                echo $data['subview']; //page load
            } else {
                redirect('admin/');
            }

    }

    public function add_edit_pf_account() {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $return = array('error' => '', 'success' => '', 'csrf_hash' => $this->security->get_csrf_hash());
        $this->form_validation->set_rules('employee_id', 'Employee', 'required|numeric');
        $this->form_validation->set_rules('account_number', 'PF Account Number', 'required|trim');
        $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'required|numeric');
        $this->form_validation->set_rules('current_balance', 'Current Balance', 'required|numeric');
        $this->form_validation->set_rules('total_employee_contribution', 'Total Employee Contribution', 'required|numeric');
        $this->form_validation->set_rules('total_employer_contribution', 'Total Company Contribution', 'required|numeric');
        $this->form_validation->set_rules('total_interest_earned', 'Total Interest Earned', 'required|numeric');
        $this->form_validation->set_rules('is_eligible_withdrawal', 'Eligible for Withdrawal', 'required|numeric');
        $this->form_validation->set_rules('is_eligible_loan', 'Eligible for Loan', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $return['error'] = $this->form_validation->error_array();
        } else {
            $data = array(
                'user_id' => (int)$this->input->post('employee_id'),
                'account_number' => $this->input->post('account_number'),
                'opening_balance' => $this->input->post('opening_balance'),
                'current_balance' => $this->input->post('current_balance'),
                'total_employee_contribution' => $this->input->post('total_employee_contribution'),
                'total_employer_contribution' => $this->input->post('total_employer_contribution'),
                'total_interest_earned' => $this->input->post('total_interest_earned'),
                'is_eligible_withdrawal' => $this->input->post('is_eligible_withdrawal'),
                'is_eligible_loan' => $this->input->post('is_eligible_loan')
            );

            $account_id = $this->input->post('account_id');
            $check_acc = $this->check_bank_account($account_id, $this->input->post('account_number'));
            if (!empty($check_acc)) {
                $return['error'] = 'Provident Fund Bank Account Number already exists.';
                $this->output($return);
                exit;
            }

            if ($account_id) { // Edit operation
                $result = $this->Provident_fund_model->update_employee_pf_account($account_id, $data);
                if ($result) {
                    $return['success'] = 'Provident Fund Account updated successfully.';
                } else {
                    $return['error'] = 'Failed to update Provident Fund Account.';
                }
            } else { // Add operation
                $result = $this->Provident_fund_model->add_employee_pf_account($data);
                if ($result) {
                    $return['success'] = 'Provident Fund Account added successfully.';
                } else {
                    $return['error'] = 'Failed to add Provident Fund Account.';
                }
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }
    function check_bank_account($account_id = null, $acc = null) {
        if (!empty($account_id)) {
            $this->db->where('account_id !=', $account_id)->where('account_number', $acc);
        } else {
            $this->db->where('account_number', $acc);
        }
        $result = $this->db->get('hrsale_provident_fund_accounts')->row();
        return $result;
    }

    public function add_edit_contribution() {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $return = array('error' => '', 'success' => '', 'csrf_hash' => $this->security->get_csrf_hash());
        $this->form_validation->set_rules('employee_id', 'Employee', 'required|numeric');
        $this->form_validation->set_rules('contribution_month', 'Contribution Month', 'required|trim');
        $this->form_validation->set_rules('employee_contribution', 'Employee Contribution', 'required|numeric');
        $this->form_validation->set_rules('employer_contribution', 'Company Contribution', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $return['error'] = $this->form_validation->error_array();
        } else {
            $user_id = (int)$this->input->post('employee_id');
            $pf_account = $this->Provident_fund_model->get_employee_pf_account($user_id);

            if (!$pf_account) {
                $return['error'] = 'No Provident Fund account found for the selected employee.';
                $this->output->set_content_type('application/json')->set_output(json_encode($return));
                return; // Stop execution
            }

            $data = array(
                'user_id' => $user_id,
                'account_id' => $pf_account->account_id, // Add account_id here
                'contribution_month' => $this->input->post('contribution_month') . '-01', // Append -01 for valid date
                'employee_contribution' => $this->input->post('employee_contribution'),
                'employer_contribution' => $this->input->post('employer_contribution'),
                'total_contribution' => $this->input->post('employee_contribution') + $this->input->post('employer_contribution')
            );

            $contribution_id = $this->input->post('contribution_id');

            if ($contribution_id) { // Edit operation
                $result = $this->Provident_fund_model->update_contribution($contribution_id, $data);
                if ($result) {
                    $return['success'] = 'Contribution updated successfully.';
                } else {
                    $return['error'] = 'Failed to update contribution.';
                }
            } else { // Add operation
                $result = $this->Provident_fund_model->add_contribution($data);
                if ($result) {
                    $return['success'] = 'Contribution added successfully.';
                } else {
                    $return['error'] = 'Failed to add contribution.';
                }
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function get_employee_pf_balance() {


        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $return = array('balance' => 0, 'error' => '', 'csrf_hash' => $this->security->get_csrf_hash());
        $user_id = (int)$this->input->post('user_id');



        if (empty($user_id)) {
            $return['error'] = 'Invalid employee selected.';
        } else {
            $pf_account = $this->Provident_fund_model->get_employee_pf_account($user_id);
            if ($pf_account) {
                $return['balance'] = (float)$pf_account->current_balance;
            } else {
                $return['error'] = 'No Provident Fund account found for this employee.';
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function add_edit_withdrawal() {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $return = array('error' => '', 'success' => '', 'csrf_hash' => $this->security->get_csrf_hash());
        $this->form_validation->set_rules('employee_id', 'Employee', 'required|numeric');
        $this->form_validation->set_rules('withdrawal_type', 'Withdrawal Type', 'required|trim');
        $this->form_validation->set_rules('requested_amount', 'Requested Amount', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $return['error'] = $this->form_validation->error_array();
        } else {
            $user_id = (int)$this->input->post('employee_id');
            $pf_account = $this->Provident_fund_model->get_employee_pf_account($user_id);

            if (!$pf_account) {
                $return['error'] = 'No Provident Fund account found for the selected employee.';
                $this->output->set_content_type('application/json')->set_output(json_encode($return));
                return; // Stop execution
            }

            $data = array(
                'user_id' => $user_id,
                'account_id' => $pf_account->account_id,
                'withdrawal_type' => $this->input->post('withdrawal_type'),
                'requested_amount' => $this->input->post('requested_amount'),
                'purpose' => $this->input->post('purpose'),
                'approved_amount' => $this->input->post('approved_amount'),
                'remarks' => $this->input->post('remarks'),
                'request_date' => date('Y-m-d H:i:s'),
                'status' => 'pending'
            );

            $withdrawal_id = $this->input->post('withdrawal_id');

            if ($withdrawal_id) { // Edit operation
                $result = $this->Provident_fund_model->update_withdrawal_request($withdrawal_id, $data);
                if ($result) {
                    $return['success'] = 'Withdrawal request updated successfully.';
                } else {
                    $return['error'] = 'Failed to update withdrawal request.';
                }
            } else { // Add operation
                $result = $this->Provident_fund_model->add_withdrawal_request($data);
                if ($result) {
                    $return['success'] = 'Withdrawal request added successfully.';
                } else {
                    $return['error'] = 'Failed to add withdrawal request.';
                }
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }

    public function get_withdrawal_details() {
        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        $withdrawal_id = (int)$this->input->post('withdrawal_id');
        $withdrawal = $this->Provident_fund_model->get_withdrawal_details($withdrawal_id);

        if ($withdrawal) {
            $return['success'] = true;
            $return['data'] = $withdrawal;
        } else {
            $return['success'] = false;
            $return['error'] = 'Withdrawal request not found.';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($return));
    }


}
