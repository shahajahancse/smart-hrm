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



if ( ! function_exists('leave_cal'))
{
    // leave cal
    function leave_cal($id)
    {
        $CI =& get_instance();
        $data = array();
        $data['leaves'] = array();
        $emp_info = $CI->db->where('user_id', $id)->get('xin_employees')->row();

        $sql = 'SELECT SUM(qty) as qty FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ? and current_year = ?';

        $join_cal_date = date("Y-m-d", strtotime("$emp_info->date_of_joining +3 month"));

        if (date("Y") > date("Y", strtotime($join_cal_date))) {
            $binds = array($id,1,2,date("Y"));
            $query = $CI->db->query($sql, $binds);
            $qty = $query->row()->qty;
            $els['id'] = 1;
            $els['leave_name'] = "Earn leave";
            $els['qty'] = 12 - $qty;
            array_push($data['leaves'],$els);

            $binds = array($id,2,2,date("Y"));
            $query = $CI->db->query($sql, $binds);
            $qty = $query->row()->qty;
            $els['id'] = 2;
            $els['leave_name'] = "Sick leave";
            $els['qty'] = 4 - $qty;
            array_push($data['leaves'],$els);
            $data['ability'] = true;

        } else if (strtotime(date("Y-m-d")) < strtotime($join_cal_date)) {
            $els['id'] = 1;
            $els['leave_name'] = "Earn leave";
            $els['qty'] = 0;
            array_push($data['leaves'],$els);
            
            $els['id'] = 2;
            $els['leave_name'] = "Sick leave";
            $els['qty'] = 0;
            array_push($data['leaves'],$els);
            $data['ability'] = false;
        } else {
            $binds = array($id,1,2,date("Y"));
            $query = $CI->db->query($sql, $binds);
            $qty = $query->row()->qty;

            $effective_date = date("Y")."-12-31";
            $d1 = new DateTime($effective_date); 
            $d2 = new DateTime($join_cal_date);   
            $Months = $d2->diff($d1); 
            $month = $Months->m;

            $els['id'] = 1;
            $els['leave_name'] = "Earn leave";
            $els['qty'] = $month - $qty;
            array_push($data['leaves'],$els);


            $binds = array($id,2,2,date("Y"));
            $query = $CI->db->query($sql, $binds);
            $qty = $query->row()->qty;

            $els['id'] = 2;
            $els['leave_name'] = "Sick leave";
            $els['qty'] = floor($month / 3) - $qty;
            array_push($data['leaves'],$els);
            $data['ability'] = true;
        }
        return $data;
    }

}


