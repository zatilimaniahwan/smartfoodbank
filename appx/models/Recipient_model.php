<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Recipient extends REST_Controller{
    
    public function __construct()
    {
        
        parent::__construct();

        $this->load->model('usergroup_model');
    }

    //API - client sends id and on valid id usergroup information is sent back
    function usergroupById_get(){

        $id  = $this->get('id');
        
        if(!$id){

            $this->response("No ID specified", 400);

            exit;
        }

        $result = $this->usergroup_model->getusergroupbyid( $id );

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
    function usergroups_get(){

        $result = $this->usergroup_model->getallusergroups();

        if($result){

            $this->response($result, 200); 

        } 

        else{

            $this->response("No record found", 404);

        }
    }
     
    //API - create a new usergroup item in database.
    function addUsergroup_post(){
        // decode input from angular. The form of input is a json encoded
        $json = json_decode(file_get_contents('php://input'),true);
        //check the content of array
        if(!empty($json['code'])&&!empty($json['desc'])){
           
            //initialize variable code
            $code=$json['code'];
           //initialize variable desc
            $desc=$json['desc'];
            
        }

        $now = date('Y-m-d H:i:s');

         $created_dt=$now;
   
         if(!$code || !$desc ){

                $this->response("Enter complete usergroup information to save", 400);

         }else{

            $result = $this->usergroup_model->add(array("code"=>$code, "desc"=>$desc,"created_dt"=>$created_dt));

            if($result === 0){

                $this->response("Usergroup information could not be saved. Try again.", 404);

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
        if(!empty($json['code'])&&!empty($json['desc'])){
             $id=$json['id'];

            $code=$json['code'];

            $desc=$json['desc'];
        }
        
         $updated_dt = $now;
         
         if(!$code || !$desc ){

                $this->response("Enter complete state information to save", 400);

         }else{
            $result = $this->usergroup_model->update($id, array("code"=>$code, "desc"=>$desc,"updated_dt"=>$now));

            if($result === 0){

                $this->response("State information could not be saved. Try again.", 404);

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