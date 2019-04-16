<?php
  class Usergroup_model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }
      
      //API call - get a usergroup record by id
      public function getusergroupbyid($id){  

           $this->db->select('id,code,desc,created_dt');

           $this->db->from('sfb_usergroups');

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

    //API call - get all usergroups record
    public function getallusergroups(){   

        $this->db->select('id,code,desc,created_dt');

        $this->db->from('sfb_usergroups');

        $this->db->order_by("created_dt", "desc"); 

        $query = $this->db->get();

        if($query->num_rows() > 0){

          return $query->result_array();

        }else{

          return 0;

        }

    }
   
   //API call - delete a usergroup record
    public function delete($id){

       $this->db->where('id', $id);

       if($this->db->delete('sfb_usergroups')){

          return true;

        }else{

          return false;

        }

   }
   
   //API call - add new usergroup record
    public function add($data){

        if($this->db->insert('sfb_usergroups', $data)){

           return true;

        }else{

           return false;

        }

    }
    
    //API call - update a usergroup record
    public function update($id, $data){

       $this->db->where('id', $id);

       if($this->db->update('sfb_usergroups', $data)){

          return true;

        }else{

          return false;

        }

    }

}