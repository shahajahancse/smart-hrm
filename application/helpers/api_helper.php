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
        $CI->db->from('api_keys');
        $q = $CI->db->get()->row();

        if (!empty($q)) {
            $CI->db->from('xin_employees')->where('user_id', $q->user_id);
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
