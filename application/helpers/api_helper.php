<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
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
                e.username ,
                e.employee_id, 
                e.first_name, 
                e.last_name, 
                e.email, 
                e.profile_picture, 
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
                e.contact_no,
                d.department_name,
                de.designation_name,
                xin_employee_bankaccount.account_number
            ');
            $CI->db->from('xin_employees AS e');
            $CI->db->join('xin_departments AS d', 'e.department_id = d.department_id', 'left');
            $CI->db->join('xin_employee_bankaccount ', 'e.user_id = xin_employee_bankaccount.employee_id', 'left');
            $CI->db->join('xin_designations AS de', 'e.designation_id = de.designation_id', 'inner');
            $CI->db->where('e.user_id', $q->user_id);
            $query = $CI->db->get()->row();

            $imageUrl = base_url('uploads/profile/' . $query->profile_picture);
            $file_extention = $query->profile_picture;
            // dd($imageUrl);

            if ( $query->profile_picture== "") {
                $file_extention = 'default_male.jpg';
                if ($query->gender == 'Male') {
                    $imageUrl = base_url('uploads/profile/default_male.jpg');
                }else {
                    $imageUrl = base_url('uploads/profile/default_female.jpg');
                }
            }   
             
            if($imageUrl){
                if ($query->gender == 'Male') {
                    $imageUrl = base_url('uploads/profile/default_male.jpg');
                }else {
                    $imageUrl = base_url('uploads/profile/default_female.jpg');
                }
            };       

            $imageData = file_get_contents($imageUrl);
            $extension = pathinfo($file_extention, PATHINFO_EXTENSION);
            $base64Image = 'data:image/' . $extension . ';base64,' . base64_encode($imageData);
            $query->profile_picture = $base64Image;
            $sql = [];
            if (empty($sql)) {
                $sql = array('official_number'=> null );
            }    
            $mergedObject = (object) array_merge((array) $query, (array) $sql);
            $data = array(
                'user_info' => $mergedObject,
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