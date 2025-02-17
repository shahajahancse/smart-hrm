<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();
          $this->load->library('form_validation');
          //load the models
          $this->load->model('Xin_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Department_model');
		  $this->load->model('Files_model');
     }
	 
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		$data['title'] = $this->lang->line('xin_files_manager').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['breadcrumbs'] = $this->lang->line('xin_files_manager');
		$data['path_url'] = 'files_manager';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if($system[0]->module_files=='true'){
			if(in_array('47',$role_resources_ids)) {
				if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/file_manager/file_manager", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard/');
			}
		} else {
			redirect('admin/dashboard/');
		}
	}
	
	// Validate and update info in database // social info
	public function add_files() {
	
		if($this->input->post('type')=='file_info') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$file_setting = $this->Xin_model->read_file_setting_info(1);
		$ifilesize = 1000000 * $file_setting[0]->maximum_file_size;
		/* Check if file uploaded..*/
		if($this->input->post('department_id') === ''){
			$Return['error'] = $this->lang->line('xin_employee_error_department');
		} else if($_FILES['xin_file']['size'] == 0 && null ==$this->input->post('remove_profile_picture')) {
			$Return['error'] = $this->lang->line('xin_error_select_file');
		} else if($_FILES['xin_file']['size'] > $ifilesize) {
			$Return['error'] = $this->lang->line('xin_error_file_size_is').' '.$file_setting[0]->maximum_file_size.'MB';
		} else {
			if(is_uploaded_file($_FILES['xin_file']['tmp_name'])) {
				
				//checking image type
				$allowed =  explode( ',',$file_setting[0]->allowed_extensions);
				$filename = $_FILES['xin_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				//if(filesize($_FILES['xin_file']['tmp_name']) > 0) {
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["xin_file"]["tmp_name"];
						$profile = "uploads/files/";
						$set_img = base_url()."uploads/files/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$name = basename($_FILES["xin_file"]["name"]);
						$newfilename = 'file_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						// file name
						$fname = $newfilename;
						// file size
						$fsize = $_FILES['xin_file']['size'];
						// file size
						$fext = $ext;
						
						//UPDATE Employee info in DB
						$data = array(
						'department_id' => $this->input->post('department_id'),
						'user_id' => $this->input->post('user_id'),
						'file_name' => $fname,
						'file_size' => $fsize,
						'file_extension' => $fext,
						'created_at' => date('Y-m-d h:i:s')
						);
						
						$result = $this->Files_model->add($data);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('xin_success_file_uploaded');
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
						$this->output($Return);
						exit;
						
					} else {
						$Return['error'] = $this->lang->line('xin_upload_file_only_for_resume').' '.$file_setting[0]->allowed_extensions;
					}
				//}
				//else {
//					$Return['error'] = 'File size is greater than .'.$file_setting[0]->maximum_file_size.'MB';
//				}//size
				}
			}
							
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
	}
	
	// all documents - listing
	public function files_list() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/file_manager/file_manager", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$id = $this->uri->segment(5);
		if($id=='0'){
			$file = $this->Files_model->get_files();
		} else {
			$file = $this->Files_model->department_files($id);
		}
		
		$data = array();

        foreach($file->result() as $r) {
			
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}
			$fsize = $this->Files_model->format_size_units($r->file_size);
			  
			$created_at = $this->Xin_model->set_date_time_format($r->created_at);
			if($r->file_name!='' && $r->file_name!='no file') {
			 $functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/download?type=files&filename='.$r->file_name.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span>';
			 } else {
				 $functions ='';
			 }
			 		
		$data[] = array(
			$functions.'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-file_id="'. $r->file_id . '" data-field_type="file_manager"><span class="fa fa-pencil"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->file_id . '" data-token_type="document"><span class="fa fa-trash"></span></button></span>',
			$r->file_name,
			$department_name,
			$fsize,
			$r->file_extension,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $file->num_rows(),
			 "recordsFiltered" => $file->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('file_id');
		$result = $this->Files_model->read_file_information($id);
		$data = array(
				'file_id' => $result[0]->file_id,
				'department_id' => $result[0]->department_id,
				'file_name' => $result[0]->file_name
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/file_manager/dialog_file', $data);
		} else {
			redirect('');
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='file') {
			
		$id = $this->input->post('file_id');
				
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('file_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_task_file_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$fname = $this->input->post('file_name').'.'.$this->input->post('ext_name');
		$directory = "uploads/files/";
			
		// get department
		rename($directory.$this->input->post('oldfname'), $directory.$fname);
	
		$data = array(
		'file_name' => $fname
		);
		
		$result = $this->Files_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_file_name_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function setting_info() {
	
		if($this->input->post('type')=='setting_info') {
			
		$id = 1;
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('maximum_file_size')==='') {
        	$Return['error'] = $this->lang->line('xin_error_max_file_size_required');
		} else if($this->input->post('allowed_extensions')==='') {
        	$Return['error'] = $this->lang->line('xin_error_file_extension_required');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$allowed_extensions = str_replace(array('php', '', 'js', '','html', ''), '',$this->input->post('allowed_extensions'));
						
		$data = array(
		'maximum_file_size' => $this->input->post('maximum_file_size'),
		'allowed_extensions' => $allowed_extensions,
		'is_enable_all_files' => $this->input->post('view_all_files'),
		'updated_at' => date('Y-m-d h:i:s')
		);
		
		$result = $this->Files_model->update_file_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_file_settings_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	 // delete employee record
	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Files_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_file_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>