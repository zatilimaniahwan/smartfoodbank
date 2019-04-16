<?php
  class State_model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }
      
      //API call - get a state record by id
      public function getstatebyid($id){  

           $this->db->select('id,code,desc,created_dt,updated_dt');

           $this->db->from('sfb_states');

           $this->db->where('id',$id);

           $query = $this->db->get();
           
           if($query->num_rows() == 1)
           {

               return $query->result_array();

           }
           else
           {

             return 0;

          }

      }

    //API call - get all states record
    public function getallstates(){   

        $this->db->select('id,code,desc,created_dt,updated_dt');

        $this->db->from('sfb_states');

        $this->db->order_by("code", "asc"); 

        $query = $this->db->get();

        if($query->num_rows() > 0){

          return $query->result_array();

        }else{

          return 0;

        }

    }
   
   //API call - delete a state record
    public function delete($id){

       $this->db->where('id', $id);

       if($this->db->delete('sfb_states')){

          return true;

        }else{

          return false;

        }

   }
   
   //API call - add new state record
    public function add($data){

        if($this->db->insert('sfb_states', $data)){

           return true;

        }else{

           return false;

        }

    }
    
    //API call - update a state record
    public function update($id, $data){

       $this->db->where('id', $id);

       if($this->db->update('sfb_states', $data)){

          return true;

        }else{

          return false;

        }

    }

}