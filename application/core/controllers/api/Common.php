<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Common extends REST_Controller {

    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model('Api_model');
        $this->load->model('Common_model');
    }

    public function common_dmsr_get(){
        $restarray=array();

        $division = $this->Common_model->get_division();
        foreach($division as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray['division'][]=$tmp;
        }

        $member = $this->Common_model->get_member_type();
        foreach($member as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray['member'][]=$tmp;
        }

        $section = $this->Common_model->set_scout_section();
        foreach($section as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray['section'][]=$tmp;
        }

        $region = $this->Common_model->get_regions();
        foreach($region as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray['region'][]=$tmp;
        }

        if($restarray){
            $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function institute_get(){
        $terms=$this->input->get('term');
        $curdt=$this->Api_model->get_institute($terms);
        $this->response($curdt, REST_Controller::HTTP_OK); 
    }

    public function banbeis_institute_get(){
        // $id = $this->get('id'); 
        
        $results = $this->Api_model->get_banbeis_institute();
        // print_r($results); exit;

        // $restarray=array();        
        // foreach($results as $k=>$row)
        // {
        //     if($k=='')continue;
        //     $tmp=array('id'=>$k, 'name'=>$row);
        //     $restarray[]=$tmp;
        // }
       /* print_r($results);
        exit;*/
        // foreach ($results as $value) {
        //     echo 'schoolNameArray.add("'.$value['name'].'");';
        //     echo '<br>';
        // }
        // exit;
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_badge_get(){
        $memberID = $this->get('memberID'); 
        $sectionID = $this->get('sectionID'); 
        
        $results = $this->Common_model->get_badges($memberID, $sectionID);
        $restarray=array();        
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_role_get(){
        $memberID = $this->get('memberID'); 
        $sectionID = $this->get('sectionID'); 
        
        $results = $this->Common_model->get_roles($memberID, $sectionID);
        $restarray=array();        
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function member_type_get(){
        $results = $this->Common_model->get_member_type();
        $restarray=array();
        foreach($results as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_section_get(){
        $results = $this->Common_model->set_scout_section();
        $restarray=array();
        foreach($results as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    // public function scout_section_value_get(){
    //     $results = $this->Common_model->get_scout_section_value();
    //     $restarray=array();
    //     foreach($results as $k=>$div)
    //     {
    //         if($k=='')continue;
    //         $tmp=array('id'=>$k, 'name'=>$div);
    //         $restarray[]=$tmp;
    //     }
    //     if($results){
    //        $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
    //     }else{
    //         $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
    //     }
    // }

    public function occupations_get(){
        $results = $this->Common_model->get_occupations();
        $restarray=array();
        foreach($results as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function blood_group_get(){
        $results = $this->Common_model->get_blood_group();
        $restarray=array();
        foreach($results as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_regions_get(){
        $results = $this->Common_model->get_regions();
        $restarray=array();
        foreach($results as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_districts_get(){
        $id = $this->get('id'); 
        
        $results = $this->Common_model->get_scout_districts($id);
        $restarray=array();        
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_upazila_get(){
        $id = $this->get('id'); 
        
        $results = $this->Common_model->get_scout_upazila_thana($id);
        $restarray=array();
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_group_get(){
        $id = $this->get('id'); 
        $upazila = $this->get('upazila'); 
        
        $results = $this->Common_model->get_scout_group_office($id, $upazila);
        $restarray=array();
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function scout_unit_get(){
        $id = $this->get('id'); 
        
        $results = $this->Common_model->get_scout_unit_office($id);
        $restarray=array();
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }    

    public function division_get(){
        $results = $this->Common_model->get_division();
		$restarray=array();
		foreach($results as $k=>$div)
		{
			if($k=='')continue;
			$tmp=array('id'=>$k, 'name'=>$div);
			$restarray[]=$tmp;
		}
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function district_get(){
        $id = $this->get('id'); 
        
        $results = $this->Common_model->get_district($id);
        $restarray=array();
        $sl=0;
        foreach($results as $k=>$row)
        {
            
            if($k=='')continue;
            $sl++;
            $tmp=array('id'=>$k, 'name'=>$row, 'sl' => $sl);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function upazila_thana_get(){
        $id = $this->get('id'); 
        
        $results = $this->Common_model->get_upazila_thana($id);
        $restarray=array();
        foreach($results as $k=>$row)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$row);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function religion_get(){
        $results = $this->Common_model->set_religion();
        $restarray=array();
        foreach($results as $k=>$div)
        {
            if($k=='')continue;
            $tmp=array('id'=>$k, 'name'=>$div);
            $restarray[]=$tmp;
        }
        if($results){
           $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }
}
