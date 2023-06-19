<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accessories extends MY_Controller {
	
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
     $data['path_url'] = "Item";    
     $data['results'] = $this->db->get('product_accessories')->result();

     $datas['subview']= $this->load->view('admin/accessories/index',$data,TRUE);  
     $this->load->view('admin/layout/layout_main', $datas); 


    }

public function category($id = null){
     $data = $this->page_loads();
     $data['title'] = 'Add Category'.' | '.$this->Xin_model->site_title();
     $data['breadcrumbs'] = "Add Category";
     $data['path_url'] = "Category";
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
        } else {
            if($this->Accessories_model->add_category('product_accessory_categories', $form_data)){
                $this->session->set_flashdata('success', 'Successfully Insert Done');
            } else {
                $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
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

     $data['title'] = 'Add Device Model'.' | '.$this->Xin_model->site_title();
	 $data['breadcrumbs'] = "Add Model";
	 $data['path_url'] = "Model";
     $this->form_validation->set_rules('cat_id', 'Category Name', 'required|trim');
     $this->form_validation->set_rules('model_name', 'Device Model', 'required|trim');
     $this->form_validation->set_rules('status', 'Status ', 'required|trim');
    if ($this->form_validation->run() == true){
        $form_data = array(
                        'cat_id'       => $this->input->post('cat_id'),
                        'model_name'       => $this->input->post('model_name'),
                        'details'          => $this->input->post('details'),
                        'status'           => $this->input->post('status'),
			        );    
        if ($hid = $this->input->post('hidden_id')) {
            $this->db->where('id', $hid)->update('product_accessories_model', $form_data);
            $this->session->set_flashdata('success', 'Successfully Updated Done');
        } else {
            if($this->Accessories_model->add_device('product_accessories_model', $form_data)){
                $this->session->set_flashdata('success', 'Successfully Insert Done');
            } else {
                $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
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

public function item_add($id = null){

     $data['title'] = 'Add Device Model'.' | '.$this->Xin_model->site_title();
	 $data['breadcrumbs'] = "Add Item";
	 $data['path_url'] = "Model";
     $this->form_validation->set_rules('cat_id', 'Category Name', 'required|trim');
     $this->form_validation->set_rules('device_name_id', 'Device Name', 'required|trim');
     $this->form_validation->set_rules('device_model', 'Device Model', 'required|trim');
     $this->form_validation->set_rules('description', 'Description', 'required|trim');
     $this->form_validation->set_rules('remark', 'Remark', 'required|trim');
     $this->form_validation->set_rules('image', 'Image', 'required|trim');
     $this->form_validation->set_rules('user_id', 'User', 'required|trim');
     $this->form_validation->set_rules('status', 'Status ', 'required|trim');

     if ($this->form_validation->run() == true){
        $form_data = array(
                            'cat_id'         => $this->input->post('cat_id'),
                            'device_name_id' => $this->input->post('device_name_id'),
                            'device_model'   => $this->input->post('device_model'),
                            'description'    => $this->input->post('description'),
                            'remark'         => $this->input->post('remark'),
                            'image'          => $this->input->post('image'),
                            'user_id'        => $this->input->post('user_id'),
                            'status'         => $this->input->post('status'),
        );    

        //     if ($hid = $this->input->post('hidden_id')) {
        //         $this->db->where('id', $hid)->update('product_accessories_model', $form_data);
        //         $this->session->set_flashdata('success', 'Successfully Updated Done');
        //     } else {
        //         if($this->Accessories_model->add_device('product_accessories_model', $form_data)){
        //             $this->session->set_flashdata('success', 'Successfully Insert Done');
        //         } else {
        //             $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
        //         }
        //     }
        // }
        // if($id != null) {
        //   $data['row']      = $this->Accessories_model->get_cat_model_info($id); // get id wise data  
        
    }   
    $data['categories'] = $this->db->select('*')->get('product_accessory_categories')->result(); //showing category list
    $data['models']     = $this->db->select('*')->get('product_accessories_model')->result(); //showing model list
    $data['users']     = $this->db->select('*')->get('xin_employees')->result(); //showing model list
    $data['results']    = $this->Accessories_model->get_cat_model_info(); //showing data 
    $datas['subview']   = $this->load->view('admin/accessories/item_add',$data,TRUE);  
                          $this->load->view('admin/layout/layout_main', $datas); 
}

}    

?>