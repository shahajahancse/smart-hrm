<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Readable print_r
 *
 * Prints human-readable information about a variable
 *
 * @access  public
 * @param   mixed 
 */
if ( ! function_exists('api_auth'))
{
    function api_auth($var)
    {
        $CI =&  get_instance();
        $CI->db->from('api_keys')->where('api_key',$var);

        $q = $CI->db->get()->row();

        
        if (!empty($q)) {
            $CI->db->select('e.user_id, e.employee_id, e.office_shift_id, e.first_name, e.last_name, e.username, e.email, e.date_of_birth, e.gender, e.status, e.e_status, e.user_role_id, e.department_id, e.sub_department_id, e.designation_id, e.company_id, e.location_id, e.view_companies_id, e.salary_template, e.hourly_grade_id, e.monthly_grade_id, e.date_of_joining, e.notify_incre_prob, e.notify_incre_prob, e.marital_status, e.salary, e.wages_type, e.basic_salary, e.daily_wages, e.salary_ssempee, e.salary_ssempeer, e.salary_income_tax, e.salary_overtime, e.salary_commission, e.salary_claims, e.salary_paid_leave, e.salary_director_fees, e.salary_bonus, e.salary_advance_paid, e.address, e.state, e.city, e.zipcode, e.profile_picture, e.profile_background, e.resume, e.skype_id, e.contact_no, e.facebook_link, e.twitter_link, e.blogger_link, e.linkdedin_link, e.google_plus_link, e.instagram_link, e.pinterest_link, e.youtube_link, e.is_active, e.last_login_date, e.last_logout_date, e.last_login_ip, e.is_logged_in, e.online_status, e.fixed_header, e.compact_sidebar, e.boxed_wrapper, e.leave_categories, e.device, e.floor_status, d.department_name,de.designation_name');
            $CI->db->from('xin_employees AS e');
            $CI->db->join('xin_departments AS d', 'e.department_id = d.department_id', 'inner');
            $CI->db->join('xin_designations AS de', 'e.designation_id = de.designation_id', 'inner');
            $CI->db->where('e.user_id', $q->user_id);
            $query = $CI->db->get()->row();

            $data = array(
                'user_info' => $query,
                'status'    => true,
            );
        }else{
            $data = array(
                'user_info' => '',
                'status'    => false,
            );
        }
        return $data;
    }
}
