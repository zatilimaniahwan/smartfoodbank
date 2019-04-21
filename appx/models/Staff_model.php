<?php
  class Staff_model extends CI_Model {
       
      public function __construct(){
        $this->load->database();
      }
      
      //API call - get a staff record by id
      public function getstaffbyid($id){  
           $this->db->select('id,org_code,staff_code,fullname,password,email,usergroup');
           $this->db->from('sfb_staffs');
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

    //API call - get all staf record
    public function getallstaffs(){   
      $this->db->select('org_name,staff_code,fullname');
        $this->db->from('sfb_staffs');
        $this->db->join('sfb_organizations','sfb_organizations.code=sfb_staffs.organization_code','inner');
        $this->db->order_by('sfb_staffs.created_dt', "desc"); 
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result_array();
        }else{
          return 0;
        }
    }
   
   //API call - delete a staff record
    public function delete($id){
       $this->db->where('id', $id);
       if($this->db->delete('sfb_staffs')){
          return true;
        }else{
          return false;
        }
   }
   
   //API call - add new staff record
    public function add($data){
        if($this->db->insert('sfb_staffs', $data)){
           return true;
        }else{
           return false;
        }
    }
    
    //API call - update a staff record
    public function update($id, $data){
       $this->db->where('id', $id);
       if($this->db->update('sfb_staffs', $data)){
          return true;
        }else{
          return false;
        }
    }
}