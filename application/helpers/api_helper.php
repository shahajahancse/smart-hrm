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
                    d.department_name,
                    de.designation_name,
                    xin_employee_bankaccount.account_number
                ');
            $CI->db->from('xin_employees AS e');
            $CI->db->join('xin_departments AS d', 'e.department_id = d.department_id', 'left');
            $CI->db->join('xin_employee_bankaccount ', 'e.user_id = xin_employee_bankaccount.employee_id', 'left');
            $CI->db->join('xin_designations AS de', 'e.designation_id = de.designation_id', 'inner');
            // $CI->db->where('pa.number = mn.id');
            $CI->db->where('e.user_id', $q->user_id);
            $query = $CI->db->get()->row();
            // dd();
     
// Your image URL
$imageUrl = base_url('uploads/profile/' . $query->profile_picture);
$file_extention = $query->profile_picture;
// Check if the image URL is null or the file doesn't exist
if ($imageUrl === null || !file_exists($imageUrl)) {
    $file_extention = 'default_male.jpg';
    if ($query->gender == 'Male') {
        $imageUrl = base_url('uploads/profile/default_male.jpg');
    } else {
        $imageUrl = base_url('uploads/profile/default_female.jpg');
    }
}

// Fetch the image data from the URL
$imageData = file_get_contents($imageUrl);

// Get the file extension from the profile picture
$extension = pathinfo($file_extention, PATHINFO_EXTENSION);

// Encode the image data to base64
$base64Image = 'data:image/' . $extension . ';base64,' . base64_encode($imageData);

// Output or use the $base64Image as needed

$query->profile_picture = $base64Image;
// dd($query);
            $sql = $CI->db->select('mobile_numbers.number as official_number')
                          ->from('mobile_numbers')
                          ->join('product_accessories','mobile_numbers.id = product_accessories.number')
                          ->where('product_accessories.user_id',$query->user_id)
                          ->get()->row();
            // dd($sql);         
            if (empty($sql)) {
                // $sql = new stdClass();
                $sql = array('official_number'=> null );
            }    
            $mergedObject = (object) array_merge((array) $query, (array) $sql);
            // dd($sql);
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
