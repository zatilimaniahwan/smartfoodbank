<?php
  class Box_model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }
      
      //API call - get a box record by id
      public function getboxbyid($id){  

           $this->db->select('id,ip_address,ssid,password,sensor_signal,created_dt,updated_dt');

           $this->db->from('sfb_boxes');

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

    //API call - get all boxes record
    public function getallboxes(){   

        $this->db->select('id,ip_address,ssid,password,sensor_signal,created_dt,updated_dt');

        $this->db->from('sfb_boxes');

        $this->db->order_by("id", "asc"); 

        $query = $this->db->get();

        if($query->num_rows() > 0){

          return $query->result_array();

        }else{

          return 0;

        }

    }
   
   //API call - delete a box record
    public function delete($id){

       $this->db->where('id', $id);

       if($this->db->delete('sfb_boxes')){

          return true;

        }else{

          return false;

        }

   }
   
   //API call - add new box record
    public function add($data){

        if($this->db->insert('sfb_boxes', $data)){

           return true;

        }else{

           return false;

        }

    }
    
    //API call - update a book record
    public function update($id, $data){

       $this->db->where('id', $id);

       if($this->db->update('sfb_boxes', $data)){

          return true;

        }else{

          return false;

        }

    }

}