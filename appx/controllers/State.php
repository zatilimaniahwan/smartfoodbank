<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class State extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('state_model');
    }

    //API - client sends id and on valid id state information is sent back
    function stateById_get(){

        $id  = $this->get('id');
        
        if(!$id){

            $this->response("No ID specified", 400);

            exit;
        }

        $result = $this->state_model->getstatebyid( $id );

        if($result){

            $this->response($result, 200); 

            exit;
        } 
        else{

             $this->response("Invalid ID", 404);

            exit;
        }
    } 

    //API -  Fetch All states
    function states_get(){

        $result = $this->state_model->getallstates();

        if($result){

            $this->response($result, 200); 

        } 

        else{

            $this->response("No record found", 404);

        }
    }
     
    //API - create a new state item in database.
    function addState_post(){
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

    
    //API - update a state
    function updateState_put(){

        $now = date('Y-m-d H:i:s');
        // decode input from angular. The form of input is a json encoded
        $json = json_decode(file_get_contents('php://input'),true);
        //check the content of array
        if(!empty($json['code'])&&!empty($json['desc'])){

            $code=$json['code'];

            $desc=$json['desc'];
        }

         $id = $this->put('id');

         $updated_dt = $now;
         
         if(!$code || !$desc ){

                $this->response("Enter complete state information to save", 400);

         }else{
            $result = $this->state_model->update($id, array("code"=>$code, "desc"=>$desc,"updated_dt"=>$now));

            if($result === 0){

                $this->response("State information could not be saved. Try again.", 404);

            }else{

                $this->response("success", 200);  

            }

        }

    }

    //API - delete a state
    function deleteState_delete()
    {

        $id  = $this->delete('id');

        if(!$id){

            $this->response("Parameter missing", 404);

        }
         
        if($this->state_model->delete($id))
        {

            $this->response("Success", 200);

        } 
        else
        {

            $this->response("Failed", 400);

        }

    }


}