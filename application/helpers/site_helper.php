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


