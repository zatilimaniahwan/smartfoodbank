<?php
  class Organization_model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }
      
      //API call - get a usergroup record by id
      public function getorganizationbyid($id){  

           $this->db->select('id,reg_no,code,org_name,address,state_id,email,tel_no,fax_no');

           $this->db->from('sfb_organizations');

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
    public function getallorganizations(){   

      $this->db->select('id,reg_no,code,org_name,address,state_id,email,tel_no,fax_no');

        $this->db->from('sfb_organizations');

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

       if($this->db->delete('sfb_organizations')){

          return true;

        }else{

          return false;

        }

   }
   
   //API call - add new usergroup record
    public function add($data){

        if($this->db->insert('sfb_organizations', $data)){

           return true;

        }else{

           return false;

        }

    }
    
    //API call - update a usergroup record
    public function update($id, $data){

       $this->db->where('id', $id);

       if($this->db->update('sfb_organizations', $data)){

          return true;

        }else{

          return false;

        }

    }

}