<?php

require(APPPATH.'/libraries/REST_Controller.php');
require(APPPATH.'/libraries/Bcrypt.php');
 
class Staff extends REST_Controller{
    
    public function __construct()
    {
        
        parent::__construct();

        $this->load->model('staff_model');
        $this->load->library('bcrypt');
    }

    //API - client sends id and on valid id staff information is sent back
    function staffById_get(){
        $id  = $this->get('id');
        if(!$id){
            $this->response("No ID specified", 400);
            exit;
        }
        $result = $this->staff_model->getstaffbyid( $id );
        if($result){
            $this->response($result, 200); 
            exit;
        } 
        else{
             $this->response("Invalid ID", 404);
            exit;
        }
    } 

    //API -  Fetch All staffs
    function staffs_get(){
        $result = $this->staff_model->getallstaffs();
        if($result){
            $this->response($result, 200); 
        } 
        else{
            $this->response("No record found", 404);
           }
    }
     
    //API - create a new staff item in database.
    function addStaff_post(){
        $now = date('Y-m-d H:i:s');
        // decode input from angular. The form of input is a json encoded
        $json = json_decode(file_get_contents('php://input'),true);
        //check the content of array
        if(!empty($json['organization_code'])&&!empty($json['staff_id'])&&!empty($json['fullname'])&&!empty($json['password'])&&!empty($json['email'])&&!empty($json['usergroup'])){
         $organization_code=$json['organization_code'];
         $staff_id=$json['staff_id'];
         $fullname=$json['fullname'];
         $password=$json['password'];
         $pass_hash=$this->bcrypt->hash_password($password);
         $email=$json['email'];
         $usergroup=$json['usergroup'];
        }
         $created_dt=$now;
         $created_by="admin";
         if(!$organization_code||!$staff_id||!$fullname||!$pass_hash||!$email||!$usergroup){
                $this->response("Enter complete staff information to save", 400);
         }else{
            $result = $this->staff_model->add(array("organization_code"=>$organization_code, "staff_code"=>$staff_id,"fullname"=>$fullname,"password"=>$pass_hash,"email"=>$email,"usergroup"=>$usergroup,"created_dt"=>$created_dt,"created_by"=>$created_by));
            if($result === 0){
                $this->response("Staff information could not be saved. Try again.", 404);
            }else{
                $this->response("success", 200);  
            }
        }
    }
    function updateRecipient_post(){
        $now = date('Y-m-d H:i:s');
        // decode input from angular. The form of input is a json encoded
        $json = json_decode(file_get_contents('php://input'),true);
        //check the content of array
        if(!empty($json['id'])&&!empty($json['organization_code'])&&!empty($json['fullname'])&&!empty($json['ic'])&&!empty($json['address'])&&!empty($json['state'])&&!empty(['age'])&&!empty($json['tel_no'])&&!empty($json['family_no'])&&!empty($json['income'])&&!empty($json['status'])){
            $id=$json['id'];
            $organization_code = $json['organization_code'];
            $fullname=$json['fullname'];
            $ic_no=$json['ic'];
            $address=$json['address'];
            $state_id=$json['state'];
            $age=$json['age'];
            $income=$json['income'];
            $phone_no=$json['tel_no'];
            $no_family=$json['family_no'];
            $status=$json['status']; 
        }
         $updated_dt = $now;
         $updated_by='admin';
         
         if(!$organization_code || !$fullname || !$ic_no || !$address || !$state_id || !$age || !$income || !$phone_no || !$no_family || !$status ){
                $this->response("Enter complete recipient information to save", 400);
         }else{
            $result = $this->recipient_model->update($id, array("organization_code"=>$organization_code, "fullname"=>$fullname,"ic_no"=>$ic_no,"address"=>$address,"state_id"=>$state_id,"age"=>$age,"phone_no"=>$phone_no,"no_family"=>$no_family,"income"=>$income,"status"=>$status,"created_dt"=>$created_dt,"created_by"=>$created_by));
            if($result === 0){
                $this->response("Recipient information could not be saved. Try again.", 404);
            }else{
                $this->response("success", 200);  
            }
        }
    }

    //API - delete recipient
    function deleteRecipient_post()
    {
        $json = json_decode(file_get_contents('php://input'),true);
        $id=$json['id'];
        if(!$id){
            $this->response("Parameter missing", 404);
        }
        if($this->recipient_model->delete($id))
        {
            $this->response("Success", 200);
        } 
        else
        {
            $this->response("Failed", 400);
        }
    }
}