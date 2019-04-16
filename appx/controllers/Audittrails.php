<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Audittrails extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('audittrails_model');
    }

    //API - client sends id and on valid id audittrails information is sent back
    function auditById_get(){

        $id  = $this->get('id');
        
        if(!$id){

            $this->response("No ID specified", 400);

            exit;
        }

        $result = $this->audittrails_model->getauditbyid( $id );

        if($result){

            $this->response($result, 200); 

            exit;
        } 
        else{

             $this->response("Invalid ID", 404);

            exit;
        }
    } 

    //API -  Fetch All audittrails
    function audit_get(){

        $result = $this->state_model->getallaudittrails();

        if($result){

            $this->response($result, 200); 

        } 

        else{

            $this->response("No record found", 404);

        }
    }
     
    //API - create a new audittrails item in database.
    function addAudit_post(){
        //date_default_timezone_set('Asia/Kuala Lumpur');
        $now = date('Y-m-d H:i:s');

         $code     = $this->post('code');

         $desc     = $this->post('desc');

         $created_dt=$now;
        
         if(!$code || !$desc ){

                $this->response("Enter complete state information to save", 400);

         }else{

            $result = $this->state_model->add(array("code"=>$code, "desc"=>$desc,"created_dt"=>$created_dt));

            if($result === 0){

                $this->response("State information could not be saved. Try again.", 404);

            }else{

                $this->response("success", 200);  
           
            }

        }

    }

    
    


}