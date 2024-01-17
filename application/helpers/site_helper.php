<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Debug Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Yura Loginov
 * @link		https://github.com/yuraloginoff/codeigniter-debug-helper.git
 */

// ------------------------------------------------------------------------

/**
 * Readable print_r
 *
 * Prints human-readable information about a variable
 *
 * @access	public
 * @param	mixed 
 */
if ( ! function_exists('GetDay'))
{
    function GetDay($sStartDate, $sEndDate)
    {  
        $CI =& get_instance();

        $sStartDate = date("Y-m-d", strtotime($sStartDate)); 
        $sEndDate = date("Y-m-d", strtotime($sEndDate)); 
          
        // Start the variable off with the start date  
        $aDays[] = date("l", strtotime($sStartDate));  
    
        // Set a 'temp' variable, sCurrentDate, with  
        // the start date - before beginning the loop  
        $sCurrentDate = $sStartDate;  
    
        // While the current date is less than the end date  
        while($sCurrentDate < $sEndDate)
        {  
            // Add a day to the current date  
            $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
     
            // Add this new day to the aDays array  
                $aDays[] = date("l", strtotime($sCurrentDate)); 
            //print_r($aDays);
        }  
     // Once the loop has finished, return the  
     return $aDays;  
    }
}


if ( ! function_exists('GetDayDate'))
{
    function GetDayDate($sStartDate, $sEndDate)
    {  
        $CI =& get_instance();

        $sStartDate = date("Y-m-d", strtotime($sStartDate)); 
        $sEndDate = date("Y-m-d", strtotime($sEndDate)); 
          
        // Start the variable off with the start date  
        $aDays[] = (object) ['date' => $sStartDate, 'day' => date("l", strtotime($sStartDate))];  
    
        // Set a 'temp' variable, sCurrentDate, with  
        // the start date - before beginning the loop  
        $sCurrentDate = $sStartDate;  
    
        // While the current date is less than the end date  
        while($sCurrentDate < $sEndDate)
        {  
            // Add a day to the current date  
            $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
     
            // Add this new day to the aDays array  
            $aDays[] = (object) ['date' => $sCurrentDate, 'day' => date("l", strtotime($sCurrentDate))]; 
            //print_r($aDays);
        }  
     // Once the loop has finished, return the  
     return $aDays;  
    }

}



if ( ! function_exists('lunch_package'))
{
    // leave cal
    function lunch_package($date)
    {
        $CI =& get_instance();

       return $CI->db->where('effective_date <=', $date)->order_by('effective_date', 'desc')->get('lunch_package')->row();

    }
}





if ( ! function_exists('cals_leave'))
{
    // leave cal
    function cals_leave($id, $year)
    {
        $CI =& get_instance();
        return $CI->db->where('emp_id', $id)->where('year', $year)->get('leave_balanace')->row();
    }
}


if ( ! function_exists('leave_cal'))
{
    // leave cal
    function leave_cal($id)
    {
        $CI =& get_instance();
        $data = array();
        $data['leaves'] = array();

        $els['id'] = 1;
        $els['leave_name'] = "Earn leave";
        $els['qty'] = get_cal_leave($id,1);
        array_push($data['leaves'],$els);


        $els['id'] = 2;
        $els['leave_name'] = "Sick leave";
        $els['qty'] = get_cal_leave($id,2);
        array_push($data['leaves'],$els);

        return $data;
    }
}

if ( ! function_exists('get_cal_leave'))
{
    function get_cal_leave($emp_id, $type)
    {

        $CI =& get_instance();
        $qty = 0;

        $emp_info = $CI->db->where('user_id', $emp_id)->get('xin_employees')->row();
        $join_cal_date = date("Y-m-d", strtotime("$emp_info->date_of_joining +3 month"));

        $sql = 'SELECT SUM(qty) as qty FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ? and current_year = ?';
        $binds = array($emp_id,$type,2,date("Y"));
        $query = $CI->db->query($sql, $binds);

        if (date("Y") > date("Y", strtotime($join_cal_date))) {
            if ($type == 2) {
                $qty = (4 - $query->row()->qty);
            } else {
                $qty = (12 - $query->row()->qty);
            }
        } else if (strtotime(date("Y-m-d")) < strtotime($join_cal_date)) {
            $qty = 0;
        } else {
            $effective_date = date("Y")."-12-31";
            $d1 = new DateTime($effective_date); 
            $d2 = new DateTime($join_cal_date);   
            $Months = $d2->diff($d1); 
            $month = $Months->m;

            if ($type == 2) {
                $qty = (floor($month / 3) - $query->row()->qty);
            } else {
                $qty = ($month - $qty);
            }
        }
        return $qty;
    }
}


