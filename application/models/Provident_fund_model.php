<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provident_fund_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Provident Fund Settings
    public function get_pf_settings($company_id) {
        $this->db->where('company_id', $company_id);
        $query = $this->db->get('hrsale_provident_fund_settings');
        return $query->row();
    }

    public function add_pf_settings($data) {
        $this->db->insert('hrsale_provident_fund_settings', $data);
        return $this->db->insert_id();
    }

    public function update_pf_settings($company_id, $data) {
        $this->db->where('company_id', $company_id);
        $this->db->update('hrsale_provident_fund_settings', $data);
        return $this->db->affected_rows();
    }

    public function delete_pf_settings($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->delete('hrsale_provident_fund_settings');
        return $this->db->affected_rows();
    }

    // Employee Provident Fund Accounts
    public function get_employee_pf_account($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('hrsale_provident_fund_accounts');
        return $query->row();
    }

    public function add_employee_pf_account($data) {
        $this->db->insert('hrsale_provident_fund_accounts', $data);
        return $this->db->insert_id();
    }

    public function update_employee_pf_account($account_id, $data) {
        $this->db->where('account_id', $account_id);
        $this->db->update('hrsale_provident_fund_accounts', $data);
        return $this->db->affected_rows();
    }

    public function delete_employee_pf_account($account_id) {
        $this->db->where('account_id', $account_id);
        $this->db->delete('hrsale_provident_fund_accounts');
        return $this->db->affected_rows();
    }

    public function get_all_employee_pf_accounts() {
        $query = $this->db->get('hrsale_provident_fund_accounts');
        return $query->result();
    }

    public function get_employee_pf_account_by_id($account_id) {
        $this->db->where('account_id', $account_id);
        $query = $this->db->get('hrsale_provident_fund_accounts');
        return $query->row();
    }

    // Provident Fund Contributions
    public function get_contribution_by_id($contribution_id) {
        $this->db->where('contribution_id', $contribution_id);
        $query = $this->db->get('hrsale_provident_fund_contributions');
        return $query->row();
    }

    public function add_contribution($data) {
        $this->db->insert('hrsale_provident_fund_contributions', $data);
        return $this->db->insert_id();
    }

    public function update_contribution($contribution_id, $data) {
        $this->db->where('contribution_id', $contribution_id);
        $this->db->update('hrsale_provident_fund_contributions', $data);
        return $this->db->affected_rows();
    }

    public function delete_contribution($contribution_id) {
        $this->db->where('contribution_id', $contribution_id);
        $this->db->delete('hrsale_provident_fund_contributions');
        return $this->db->affected_rows();
    }

    public function get_all_contributions() {
        $query = $this->db->get('hrsale_provident_fund_contributions');
        return $query->result();
    }

    public function get_contributions_by_employee_id($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('hrsale_provident_fund_contributions');
        return $query->result();
    }

    public function get_monthly_contributions_report($month, $year) {
        $this->db->select('t1.*, t2.first_name, t2.last_name');
        $this->db->from('hrsale_provident_fund_contributions as t1');
        $this->db->join('xin_employees as t2', 't1.user_id = t2.user_id', 'left');
        $this->db->where('MONTH(t1.contribution_month)', $month);
        $this->db->where('YEAR(t1.contribution_month)', $year);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_employee_pf_account_by_account_number($account_number) {
        $this->db->where('account_number', $account_number);
        $query = $this->db->get('hrsale_provident_fund_accounts');
        return $query->row();
    }

    // Provident Fund Interest
    public function get_interest_by_id($interest_id) {
        $this->db->where('interest_id', $interest_id);
        $query = $this->db->get('hrsale_provident_fund_interest');
        return $query->row();
    }

    public function add_interest($data) {
        $this->db->insert('hrsale_provident_fund_interest', $data);
        return $this->db->insert_id();
    }

    public function get_yearly_interest_report($year) {
        $this->db->select('t1.*, t2.first_name, t2.last_name');
        $this->db->from('hrsale_provident_fund_interest as t1');
        $this->db->join('xin_employees as t2', 't1.user_id = t2.user_id', 'left');
        $this->db->where('t1.interest_year', $year);
        $query = $this->db->get();
        return $query->result();
    }

    public function calculate_and_post_interest($year) {
        // Get all PF accounts
        $pf_accounts = $this->get_all_employee_pf_accounts();
        // Get PF settings (specifically bank interest rate)
        $company_id = $this->Xin_model->get_company_id_of_current_user($this->session->userdata('username')['user_id']); // Assuming this function exists
        $pf_settings = $this->get_pf_settings($company_id);

        if (!$pf_settings) {
            return false; // No settings found, cannot calculate interest
        }

        $bank_interest_rate = $pf_settings->bank_interest_rate / 100;
        $success_count = 0;

        foreach ($pf_accounts as $account) {
            // Check if interest has already been calculated for this year and account
            $this->db->where('account_id', $account->account_id);
            $this->db->where('interest_year', $year);
            $existing_interest = $this->db->get('hrsale_provident_fund_interest')->row();

            if ($existing_interest) {
                continue; // Skip if already calculated
            }

            // Calculate interest based on current balance
            $interest_amount = $account->current_balance * $bank_interest_rate;
            $balance_before_interest = $account->current_balance;
            $balance_after_interest = $account->current_balance + $interest_amount;

            // Add interest record
            $interest_data = array(
                'account_id' => $account->account_id,
                'user_id' => $account->user_id,
                'interest_year' => $year,
                'interest_amount' => $interest_amount,
                'balance_before_interest' => $balance_before_interest,
                'balance_after_interest' => $balance_after_interest
            );
            $this->add_interest($interest_data);

            // Update PF account current balance and total interest earned
            $this->update_employee_pf_account(
                $account->account_id,
                array(
                    'current_balance' => $balance_after_interest,
                    'total_interest_earned' => $account->total_interest_earned + $interest_amount
                )
            );
            $success_count++;
        }
        return $success_count;
    }

    // Provident Fund Withdrawals
    public function get_withdrawal_by_id($withdrawal_id) {
        $this->db->where('withdrawal_id', $withdrawal_id);
        $query = $this->db->get('hrsale_provident_fund_withdrawals');
        return $query->row();
    }

    public function add_withdrawal_request($data) {
        $this->db->insert('hrsale_provident_fund_withdrawals', $data);
        return $this->db->insert_id();
    }

    public function update_withdrawal_request($withdrawal_id, $data) {
        $this->db->where('withdrawal_id', $withdrawal_id);
        $this->db->update('hrsale_provident_fund_withdrawals', $data);
        return $this->db->affected_rows();
    }

    public function delete_withdrawal($withdrawal_id) {
        $this->db->where('withdrawal_id', $withdrawal_id);
        $this->db->delete('hrsale_provident_fund_withdrawals');
        return $this->db->affected_rows();
    }

    public function get_all_withdrawals() {
        $query = $this->db->get('hrsale_provident_fund_withdrawals');
        return $query->result();
    }

    public function get_withdrawal_details($withdrawal_id) {
        $this->db->where('withdrawal_id', $withdrawal_id);
        $query = $this->db->get('hrsale_provident_fund_withdrawals');
        return $query->row();
    }

    // Provident Fund Loans
    public function get_loan_by_id($loan_id) {
        $this->db->where('loan_id', $loan_id);
        $query = $this->db->get('hrsale_provident_fund_loans');
        return $query->row();
    }

    public function add_loan($data) {
        $this->db->insert('hrsale_provident_fund_loans', $data);
        return $this->db->insert_id();
    }

    public function update_loan($loan_id, $data) {
        $this->db->where('loan_id', $loan_id);
        $this->db->update('hrsale_provident_fund_loans', $data);
        return $this->db->affected_rows();
    }

    public function delete_loan($loan_id) {
        $this->db->where('loan_id', $loan_id);
        $this->db->delete('hrsale_provident_fund_loans');
        return $this->db->affected_rows();
    }

    public function get_all_loans() {
        $query = $this->db->get('hrsale_provident_fund_loans');
        return $query->result();
    }

    // Provident Fund Loan Repayments
    public function add_loan_repayment($data) {
        $this->db->insert('hrsale_provident_fund_loan_repayments', $data);
        return $this->db->insert_id();
    }

    public function get_loan_repayments_by_loan_id($loan_id) {
        $this->db->where('loan_id', $loan_id);
        $query = $this->db->get('hrsale_provident_fund_loan_repayments');
        return $query->result();
    }

    public function get_contributions_by_employee_id_and_year($user_id, $year) {
        $this->db->where('user_id', $user_id);
        $this->db->where('YEAR(contribution_month)', $year);
        $query = $this->db->get('hrsale_provident_fund_contributions');
        return $query->result();
    }

    public function get_yearly_interest_report_by_employee_id_and_year($user_id, $year) {
        $this->db->where('user_id', $user_id);
        $this->db->where('interest_year', $year);
        $query = $this->db->get('hrsale_provident_fund_interest');
        return $query->result();
    }

}