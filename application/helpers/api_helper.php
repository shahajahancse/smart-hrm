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
        $Token = str_replace('Bearer ', '', $var);

        $CI =&  get_instance();
        $CI->db->from('api_keys')->where('api_key', $Token);
        $q = $CI->db->get()->row();
        if (!empty($q)) {
            $CI->db->select('
                    e.user_id, 
                    e.employee_id, 
                    e.first_name, 
                    e.last_name, 
                    e.email, 
                    e.date_of_birth, 
                    e.gender, 
                    e.status,  
                    e.user_role_id, 
                    e.department_id, 
                    e.designation_id,  
                    e.date_of_joining, 
                    e.notify_incre_prob, 
                    e.notify_incre_prob, 
                    e.marital_status, 
                    e.salary, 
                    e.basic_salary,
                    e.floor_status, 
                    d.department_name,
                    de.designation_name
                ');
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
