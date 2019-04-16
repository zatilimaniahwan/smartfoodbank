<?php
  class AuditTrails_model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }
      
      //API call - get an audit trail record by id
      public function getauditbyisbn($isbn){  

           $this->db->select('id,module,created_by,created_dt');

           $this->db->from('sfb_audittrails');

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

    //API call - get all audit trail record
    public function getallaudittrails(){   

        $this->db->select('id,module,created_by,created_dt');

        $this->db->from('sfb_audittrails');

        $this->db->order_by("id", "asc"); 

        $query = $this->db->get();

        if($query->num_rows() > 0){

          return $query->result_array();

        }else{

          return 0;

        }

    }
   
   
   //API call - add new book record
    public function add($data){

        if($this->db->insert('sfb_audittrails', $data)){

           return true;

        }else{

           return false;

        }

    }
    

}