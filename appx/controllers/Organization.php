<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Organization extends REST_Controller{
    
    public function __construct()
    {
        
        parent::__construct();

        $this->load->model('organization_model');
    }

    //API - client sends id and on valid id usergroup information is sent back
    function organizationById_get(){

        $id  = $this->get('id');
        
        if(!$id){

            $this->response("No ID specified", 400);

            exit;
        }

        $result = $this->organization_model->getorganizationbyid( $id );

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
    function organizations_get(){

        $result = $this->organization_model->getallorganizations();

        if($result){

            $this->response($result, 200); 

        } 

        else{

            $this->response("No record found", 404);

        }
    }
     
    //API - create a new usergroup item in database.
    function addOrganization_post(){
        // decode input from angular. The form of input is a json encoded
        $json = json_decode(file_get_contents('php://input'),true);
        //check the content of array
        if(!empty($json['reg_no'])&&!empty($json['org_name'])&&!empty($json['code'])&&!empty($json['address'])&&!empty($json['state'])&&!empty($json['email'])&&!empty($json['tel_no'])){
           
          $reg_no=$json['reg_no'];
          $org_name=$json['org_name'];
          $code=$json['code'];
          $address=$json['address'];
          $state_id=$json['state'];
          $email=$json['email'];
          $tel_no=$json['tel_no'];
          $fax_no=$json['fax_no'];
            
        }

        $now = date('Y-m-d H:i:s');

         $created_dt=$now;
         $created_by="admin";
   
         if(!$reg_no||!$org_name||!$code||!$address||!$state_id||!$email||!$tel_no ){

                $this->response("Enter complete organization information to save", 400);

         }else{

            $result = $this->organization_model->add(array("reg_no"=>$reg_no,"org_name"=>$org_name,"code"=>$code,"address"=>$address,"state_id"=>$state_id,"email"=>$email,"tel_no"=>$tel_no,"fax_no"=>$fax_no,"created_dt"=>$created_dt,"created_by"=>$created_by));

            if($result === 0){

                $this->response("Organization information could not be saved. Try again.", 404);

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
        if(!empty($json['reg_no'])&&!empty($json['org_name'])&&!empty($json['code'])&&!empty($json['address'])&&!empty($json['state'])&&!empty($json['email'])&&!empty($json['tel_no'])){
            $reg_no=$json['reg_no'];
            $org_name=$json['org_name'];
            $code=$json['code'];
            $address=$json['address'];
            $state_id=$json['state'];
            $email=$json['email'];
            $tel_no=$json['tel_no'];
            $fax_no=$json['fax_no'];
        }
        
         $updated_dt = $now;
         $updated_by="admin";
         
         if(!$reg_no||!$org_name||!$code||!$address||!$state_id||!$email||!$tel_no ){

                $this->response("Enter complete organization information to save", 400);

         }else{
            $result = $this->organization_model->update($id, array("reg_no"=>$reg_no,"org_name"=>$org_name,"code"=>$code,"address"=>$address,"state_id"=>$state_id,"email"=>$email,"tel_no"=>$tel_no,"fax_no"=>$fax_no,"updated_dt"=>$cupdated_dt,"updated_by"=>$updated_by));

            if($result === 0){

                $this->response("Organization information could not be saved. Try again.", 404);

            }else{

                $this->response("success", 200);  

            }

        }

    }

    

    //API - delete usergroup
    function deleteUsergroup_post()
    {
        $json = json_decode(file_get_contents('php://input'),true);
        $id=$json['id'];
      // $id=$this->delete('id');
        //var_dump($id);

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