<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Recipient extends REST_Controller{
    
    public function __construct()
    {
        
        parent::__construct();

        $this->load->model('recipient_model');
    }

    //API - client sends id and on valid id usergroup information is sent back
    function recipientById_get(){

        $id  = $this->get('id');
        
        if(!$id){

            $this->response("No ID specified", 400);

            exit;
        }

        $result = $this->recipient_model->getrecipientbyid( $id );

        if($result){

            $this->response($result, 200); 

            exit;
        } 
        else{

             $this->response("Invalid ID", 404);

            exit;
        }
    } 

    //API -  Fetch All uergroups
    function recipients_get(){

        $result = $this->recipient_model->getallrecipients();

        if($result){

            $this->response($result, 200); 

        } 

        else{

            $this->response("No record found", 404);

        }
    }
     
    //API - create a new usergroup item in database.
    function addRecipient_post(){
        // decode input from angular. The form of input is a json encoded
        $json = json_decode(file_get_contents('php://input'),true);
        //check the content of array
        var_dump($json);
        $fullname="";
        if(!empty($json['fullname'])&&!empty($json['ic'])&&!empty($json['address'])&&!empty($json['state'])&&!empty($json['age'])&&!empty($json['tel_no'])&&!empty($json['family_no'])&&!empty($json['income'])){
           //$organization_code = $json['organization_code'];
           $fullname=$json['fullname'];
           //var_dump($fullname);exit;
           $ic_no=$json['ic'];
           $address=$json['address'];
           $state_id=$json['state'];
           $age=$json['age'];
           $income=$json['income'];
           $phone_no=$json['tel_no'];
           $no_family=$json['family_no']; 
        }

        $now = date('Y-m-d H:i:s');
         $created_dt=$now;
         $created_by="admin";
         $organization_code="KSK";
   
         if(!$fullname || !$ic_no || !$address || !$state_id || !$age || !$income || !$phone_no || !$no_family){

                $this->response("Enter complete recipient information to save", 400);

         }else{

            $result = $this->recipient_model->add(array("organisation_code"=>$organization_code, "fullname"=>$fullname,"ic_no"=>$ic_no,"address"=>$address,"state_id"=>$state_id,"age"=>$age,"phone_no"=>$phone_no,"no_family"=>$no_family,"income"=>$income,"status"=>1,"created_dt"=>$created_dt,"created_by"=>$created_by));

            if($result === 0){

                $this->response("Recipient information could not be saved. Try again.", 404);

            }else{

                $this->response("success", 200);  
           
            }

        }

    }
    function updateUsergroup_post(){

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

    

    //API - delete usergroup
    function deleteRecipient_post()
    {
        $json = json_decode(file_get_contents('php://input'),true);
        $id=$json['id'];

        if(!$id){

            $this->response("Parameter missing", 404);

        }
         
        if($this->usergroup_model->delete($id))
        {

            $this->response("Success", 200);

        } 
        else
        {

            $this->response("Failed", 400);

        }

    }


}