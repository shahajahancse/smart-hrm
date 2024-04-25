<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accessories extends MY_Controller {

    public $category = "<script>window.location.replace('category')</script>";
    public $model = "<script>window.location.replace('device_model')</script>";
    public $item = "<script>window.location.replace('index')</script>";
    public $number = "<script>window.location.replace('number_add')</script>";
	
	public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Accessories_model");
		$this->load->model("Xin_model");
		$this->load->helper('form');
        
	}
    public function page_loads(){
        $data = $this->session->userdata('username');
		if(empty($data)){ 
			redirect('admin/');
		}
        return $data;
    }

    public function index(){
         $data = $this->page_loads();
         $data['title'] = 'Item List'.' | '.$this->Xin_model->site_title();
         $data['breadcrumbs'] = "Item List";
        //  $data['path_url'] = "Index";    
         $data['results'] = $this->Accessories_model->get_product_reports_info($id=null,$status=null,$category=null);
         $datas['subview']= $this->load->view('admin/accessories/index',$data,TRUE);  
         $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function category($id = null){
         $data = $this->page_loads();
         $data['title'] = 'Add Category'.' | '.$this->Xin_model->site_title();
         $data['breadcrumbs'] = "Add Category";
        //  $data['path_url'] = "Category";
         $this->form_validation->set_rules('cat_name', 'Category Name', 'required|trim');
         $this->form_validation->set_rules('cat_short_name', 'Category Short Name', 'required|trim');
         $this->form_validation->set_rules('status', 'Status ', 'required|trim');
         if ($this->form_validation->run() == true){
         $form_data = array(
                            'cat_name'       => $this->input->post('cat_name'),
                            'cat_short_name' => $this->input->post('cat_short_name'),
                            'status'         => $this->input->post('status'),
    			          );    
            if ($hid = $this->input->post('hidden_id')) {
                $this->db->where('id', $hid)->update('product_accessory_categories', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
                echo $this->category;
            } else {
                if($this->Accessories_model->add_category('product_accessory_categories', $form_data)){
                    $this->session->set_flashdata('success', 'Successfully Insert Done');
                    echo $this->category;
                } else {
                    $this->session->set_flashdata('success', 'Sorry Something Wrong.');
                    echo $this->category;
                }
            }
        }

        if($id != null) {
          $data['row'] = $this->db->where('id',$id)->get("product_accessory_categories")->row();
        }   

         $data['results']=$this->db->select('*')->get('product_accessory_categories')->result();
         $datas['subview']= $this->load->view('admin/accessories/category',$data,TRUE);  
         $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function device_model($id = null){
         $data = $this->page_loads();
         $data['title'] = 'Add Device Model'.' | '.$this->Xin_model->site_title();
    	 $data['breadcrumbs'] = "Add Model";
    	//  $data['path_url'] = "Model";
         $this->form_validation->set_rules('cat_id', 'Category Name', 'required|trim');
         $this->form_validation->set_rules('model_name', 'Device Model', 'required|trim');
         $this->form_validation->set_rules('status', 'Status ', 'required|trim');
        if ($this->form_validation->run() == true){

            if(!empty($_FILES['image']['name'])){
                $config['upload_path'] = 'uploads/accessory_images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['image']['name'];
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('image')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            } else{
                    $picture = '';
            }
            
            $form_data = array(
                'cat_id'    => $this->input->post('cat_id'),
                'model_name'=> $this->input->post('model_name'),
                'details'   => $this->input->post('details'),
                'status'    => $this->input->post('status'),
                'image'     => $picture,
            );    
            if ($hid = $this->input->post('hidden_id')) {
                $this->db->where('id', $hid)->update('product_accessories_model', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
                 echo $this->model;
            } else {
                if($this->Accessories_model->add_device('product_accessories_model', $form_data)){
                    $this->session->set_flashdata('success', 'Successfully Insert Done');
                     echo $this->model;
                } else {
                    $this->session->set_flashdata('success', 'Sorry Something Wrong.');
                     echo $this->model;
                }
            }
        }

        if($id != null) {
          $data['row']      = $this->Accessories_model->get_cat_model_info($id); // get id wise data  
        }   
        $data['categories'] = $this->db->select('*')->get('product_accessory_categories')->result(); //showing category list
        $data['results']    = $this->Accessories_model->get_cat_model_info(); //showing data 
        $datas['subview']   = $this->load->view('admin/accessories/device_model',$data,TRUE);  
                              $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function number_add($id = null){
        $data = $this->page_loads();
        $data['title'] = 'Add Number'.' | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = "Add Number";
        // $data['path_url'] = "Number";
        $this->form_validation->set_rules('number', 'Number', 'required|trim');
        $this->form_validation->set_rules('status', 'Number', 'required|trim');
        if ($this->form_validation->run() == true){
        $form_data = array(
            'number'   => $this->input->post('number'),
            'status'   => $this->input->post('status'),
        );    
            if ($hid = $this->input->post('hidden_id')) {
            $this->db->where('id', $hid)->update('mobile_numbers', $form_data);
            $this->session->set_flashdata('success', 'Successfully Updated Done');
             echo $this->number;
            } else {
                if($this->Accessories_model->add_category('mobile_numbers', $form_data)){
                    $this->session->set_flashdata('success', 'Successfully Insert Done');
                     echo $this->number;
                } else {
                    $this->session->set_flashdata('success', 'Sorry Something Wrong.');
                     echo $this->number;
                }
            }
        }
        if($id != null) {
          $data['row'] = $this->db->where('id',$id)->get("mobile_numbers")->row();
        }   
         $data['results']=$this->db->select('*')->get('mobile_numbers')->result();
         $datas['subview']= $this->load->view('admin/accessories/number_add',$data,TRUE);  
         $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function delete($id,$table,$url){
        $delete= $this->db->where('id',$id)->delete($table);
        if($delete){
            $this->session->set_flashdata('success', 'Successfully Delete Done');
            redirect('admin/accessories/'.$url,['msg'=>1]);
        } else{
            $this->session->set_flashdata('success', 'Sorry Something Wrong.');
            redirect('admin/accessories/'.$url);
        }

    }

    public function reports(){
        $data = $this->page_loads();
        $data['title'] = 'Report'.' | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = "Report"; 
        $datas['subview'] = $this->load->view('admin/accessories/reports',$data,TRUE);  
                            $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function inventory_report($id){
        $data = $this->page_loads();
        // dd($_POST);
        $first_date  = @$_POST['first_date'];
        $second_date = @$_POST['second_date'];
        $status      = @$_POST['status'];
        $category    = @$_POST['category'];
        

        $data['reports']     = $this->Accessories_model->get_product_reports_info($id=null,$status,$category);
        if(is_string($data["reports"])){
         echo $data["reports"];
        } else{	
         $this->load->view('admin/accessories/inventory_report',$data);
        }
    }

    public function get_model($id = null,$dem=null){
        $rows = $this->db->select('*')->where('cat_id',$id)->get('product_accessories_model')->result();
        $this->load->view('admin/accessories/get_model', array('models'=>$rows,'deivice_id'=>$dem));
    }

    public function item_add($id=null){
        $data = $this->page_loads();
        if($id !=null){
            $data['title']         = 'Update Item'.' | '.$this->Xin_model->site_title();
            $data['breadcrumbs']   = "Update Item";
        }else{
            $data['title']         = 'Add Item'.' | '.$this->Xin_model->site_title();
            $data['breadcrumbs']   = "Add Item";
        }
        $this->form_validation->set_rules('cat_id', 'Category Name', 'required|trim');
        if($id != null) {
            $data['row'] = $this->db->select('*')->where('id',$id)->get("product_accessories")->row();
        }  
        if ($this->form_validation->run() == true){
            if($this->input->post('status')==1){
                $user_id = $this->input->post('user_id');
            }else{
                $user_id=null;
            }
            $form_data = array(
                'cat_id'         => $this->input->post('cat_id'),
                'device_name_id' => $this->input->post('device_name_id'),
                'device_model'   => $this->input->post('device_model'),
                'description'    => $this->input->post('description'),
                'remark'         => $this->input->post('remark'),
                // 'image'          => "",
                // 'user_id'        => $user_id,
                'status'         => $this->input->post('status'),
                // 'use_number'     => $this->input->post('use_number'),
                'number'         => $this->input->post('number'),
            );    
            // dd($form_data);
            if ($hid = $this->input->post('hidden_id')) {
                $this->db->where('id', $hid)->update('product_accessories', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
                echo $this->item;
            } 
            else {
                if($insert=$this->Accessories_model->add_device('product_accessories', $form_data)){
                    if($insert){
                        $lastInsertedId = $this->db->insert_id();
                        $query = $this->db->get_where('product_accessories', array('id' => $lastInsertedId));
                        $result = $query->row();
                        if($result->id !=null){
                            $data= array(
                            'p_a_id'        => $result->id,
                            // 'user_id'       => $result->user_id,
                            'provide_by'    => $data['user_id'],
                            'provide_date'  => date('Y-m-d H:i:s'),
                            'created_by'    => $data['user_id'],
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_by'    => $data['user_id'],
                            'updated_at'    => date('Y-m-d H:i:s'),
                            'status'        => 1,
                        );
                        $insert_data=$this->db->insert('product_accessories_working', $data);
                        if($insert_data){
                            $this->session->set_flashdata('success', 'Successfully Insert Done');
                            echo $this->item;
                        }   
                        }else{
                            $this->session->set_flashdata('success', 'Successfully Insert Done');
                            echo $this->item;
                        }
                    }
                } else{
                    $this->session->set_flashdata('success', 'Sorry Something Wrong.');
                    echo $this->item;
                }   
            }               
        }
        $data['categories']=$this->db->select('*')->get('product_accessory_categories')->result();
        $data['users']=$this->db->select('*')->get('xin_employees')->result();
        $datas['subview']= $this->load->view('admin/accessories/item_add',$data,TRUE);  
        $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function item_lists($id){
        // dd($id); 
        if($id == 1){  
            $data['rows']=$this->Accessories_model->get_product_reports_info(null,$id,null); 
            $this->load->view('admin/accessories/on_working',$data);
        }
        if($id == 2){   
            $data['rows']=$this->Accessories_model->get_product_reports_info(null,$id,null); 
            $this->load->view('admin/accessories/on_stored',$data);
        }
        if($id == 3){   
            $data['rows']=$this->Accessories_model->get_product_reports_info(null,$id,null); 
            $this->load->view('admin/accessories/on_servicing',$data);
        }
        if($id == 4){   
            $data['rows']=$this->Accessories_model->get_product_reports_info(null,$id,null); 
            $this->load->view('admin/accessories/on_destroyed',$data);
        }
        if($id == 5){   
            $data['rows']=$this->Accessories_model->get_product_reports_info(null,$id,null); 
            $this->load->view('admin/accessories/on_movement',$data);
        }
        if($id == 6){   
            $data['rows']=$this->Accessories_model->get_product_reports_info(null,null,null); 
            $this->load->view('admin/accessories/on_all',$data);
        }


    }   

    public function desk_add(){
        $data = $this->page_loads();
        $data['title'] = 'Desk List'.' | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = "Desk List";
        $datas['subview']= $this->load->view('admin/accessories/desk_add',$data,TRUE);  
        $this->load->view('admin/layout/layout_main', $datas); 
    }

    public function get_desk_list(){
        $tableData =$this->db->select('xin_employees.first_name,xin_employees.last_name,xin_employee_desk.*')
                             ->from('xin_employee_desk')
                             ->join('xin_employees', 'xin_employees.user_id = xin_employee_desk.user_id', 'left')
                             ->order_by('desk_no','ASC')
                             ->get()
                             ->result();

        // Send the data as JSON response
        header('Content-Type: application/json');
        echo json_encode($tableData);
    }

    public function add_desk(){
        // dd($_POST);
        $data['desk_no'] = $_POST['desk_no'];
        $data['status']  = $_POST['status'];
        $data['user_id'] = $_POST['user_id']==null?'':$_POST['user_id'];
        $data['floor']   = $_POST['floor'];
        $data['after_desk']   = $_POST['after_desk'];
        $data['description']   = $_POST['description'];

        // dd($_POST);
        $insert = $this->db->insert('xin_employee_desk',$data);
        if($insert && $_POST['user_id'] !=null){
            $this->db->where('user_id',$_POST['user_id'])->update('xin_employees',['floor_status'=>$_POST['floor']]);  
            header('Content-Type: application/json');
            echo json_encode("Desk added successfully");
        }
    }

    public function get_single_desk(){  
        $recordId = $this->input->get('recordId');
        $recordId = $this->db->escape_str($recordId); // Escape the input to prevent SQL injection

        $query = $this->db->get_where('xin_employee_desk', array('id' => $recordId));

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Record not found']);
        }
    
    }

    public function update_desk(){
        // dd($_POST);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $recordId    = $this->input->post('recordId');
            $deskNo      = $this->input->post('desk_no');
            $after_desk  = $this->input->post('after_desk');
            $status      = $this->input->post('status');
            $floor       = $this->input->post('floor');
            $description = $this->input->post('description');
            $userId      = $this->input->post('user_id');
            $data = array(
                'desk_no' => $deskNo,
                'after_desk' => $after_desk,
                'status' => $status,
                'floor' => $floor,
                'description' => $description,
                'user_id' => $userId
            );
            $this->db->where('id', $recordId);
            $result = $this->db->update('xin_employee_desk', $data);
            $msg    = "Update successfully";
            $err    = 'Update failed';
            $inval  = 'Invalid request';
            if ($result) {
                header('Content-Type: application/json');
                echo json_encode($msg);
            } else {
                header('Content-Type: application/json');
                echo json_encode($err);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode($inval);
        }
    }

    public function check_duplicate($id){
       $this->db->select('*');
       $this->db->where('desk_no', $id);
       $query = $this->db->get('xin_employee_desk');

        $num_rows = $query->num_rows();
       if($num_rows > 0 ){
            header('Content-Type: application/json');
            echo json_encode(['status'=>'true']);
       }

    }

     public function delete_desk_list() {
        $item_id = $this->input->post('id');
        $this->db->where('id', $item_id);
        return $this->db->delete('xin_employee_desk');
    }

    public function employee_using_device() {
        $data['title'] = 'Employee Using Device'.' | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = "Item List";
        $datas['subview']= $this->load->view('admin/accessories/employee_using_device',$data,TRUE);  
        $this->load->view('admin/layout/layout_main', $datas); 
    }
    public function employee_using_device_list(){
        // CREATE TABLE `admin_smarthr`.`employee_using_device` ( `id` INT(255) NOT NULL AUTO_INCREMENT ,  `user_id` INT(255) NOT NULL ,  `device_id` INT(255) NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;

        $employee_id = $this->input->post('employee_id');
        $this->db->select('
        employee_using_device.*, 
        xin_employees.first_name,
        xin_employees.last_name,
        product_accessories.id as product_id,
        product_accessories.device_name_id,
        product_accessories_model.model_name,
        product_accessory_categories.cat_name,
        product_accessory_categories.cat_short_name
        
        ');

        $this->db->from('employee_using_device');
        $this->db->join('xin_employees', 'xin_employees.user_id = employee_using_device.user_id', 'left');
        $this->db->join('product_accessories', 'product_accessories.id = employee_using_device.device_id', 'left');
        $this->db->join('product_accessories_model', 'product_accessories_model.id = product_accessories.device_model', 'left');
        $this->db->join('product_accessory_categories', 'product_accessory_categories.id = product_accessories.cat_id', 'left');
        $this->db->where('employee_using_device.user_id', $employee_id);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    public function employee_device_list_by_cat(){

        $cat_id = $this->input->post('cat_id');
        $this->db->select('
        product_accessories.id as product_id,
        product_accessories.device_name_id,
        product_accessories_model.model_name,
        product_accessory_categories.cat_name,
        product_accessory_categories.cat_short_name
        
        ');

        $this->db->from('product_accessories');
        $this->db->join('product_accessories_model', 'product_accessories_model.id = product_accessories.device_model', 'left');
        $this->db->join('product_accessory_categories', 'product_accessory_categories.id = product_accessories.cat_id', 'left');
        $this->db->where('product_accessories.cat_id', $cat_id);
        $this->db->where('product_accessories.status', 2);
        $this ->db->order_by('product_accessories.device_name_id', 'ASC');
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    public function update_device_using(){
        $device_id= $this->input->post('device_id');
        $this->db->where('device_id', $device_id);
        if (count($this->db->get('employee_using_device')->row()) > 0) {
            exit();
        }
        $employee_id= $this->input->post('employee_id');
        $data = array(
            'user_id' => $employee_id,
            'device_id' => $device_id
        );
        $this->db->insert('employee_using_device', $data);
        $data2=array(
            'status' => 1
        );
        $this->db->where('id', $device_id);
        $this->db->update('product_accessories', $data2);
    }
    public function remove_device_using(){
        $device_id= $this->input->post('product_id');
        $this->db->where('device_id', $device_id);
        $this->db->delete('employee_using_device');

        $data2=array(
            'status' => 2
        );
        $this->db->where('id', $device_id);
        $this->db->update('product_accessories', $data2);

    }

}

?>