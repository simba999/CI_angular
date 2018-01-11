<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends MY_Model {

    public $_table_name_lead_circle = 'lead_circle';
    public $_table_name_leads = 'leads';
    public $_table_name_users = 'users';
    public $rules = array(
    );

    function __construct() {
        parent::__construct();
    }

    public function addContactTocircle($data) {
        $insertLeadsData = array();
        $insertLeadCircleData = array();
        foreach ($data['contact_name'] as $key => $value) {
            if($value != ''){
                if(preg_match('/\s/',$value)){
                    $nameArray = explode(' ',trim($value));
                    $insertLeadsData['FirstName'] = $nameArray[0];
                    $insertLeadsData['LastName'] = $nameArray[1];
                }else{
                    $insertLeadsData['FirstName'] = $value;
                }
                $insertLeadsData['ClientId'] = $this->session->userdata('id');
                $insertLeadsData['LeadSourceId'] = $this->session->userdata('id');
                $insertLeadsData['AssignedUserId'] = $this->session->userdata('id');
                $insertLeadsData['CreatedBy'] = $this->session->userdata('id');
                $insertLeadsData['LeadSourceId'] = 1;
                $insertLeadsData['LeadStatusId'] = 1;
                $this->db->insert($this->_table_name_leads,$insertLeadsData);
                $relatedLeadId = $this->db->insert_id();

                $insertLeadCircleData['CircleId'] = $data['circle'][$key];
                $insertLeadCircleData['LeadId'] = $relatedLeadId;
                $insertLeadCircleData['CreatedBy'] = $this->session->userdata('id');
                $this->db->insert($this->_table_name_lead_circle,$insertLeadCircleData);
                $relatedLeadCircleId = $this->db->insert_id();
                
            }

        }
        if($relatedLeadId != ''){
            
            $this->db->set('ContactAdded',1);
            $this->db->where('id', $this->session->userdata('id'));
            $this->db->update($this->_table_name_users);
            $this->session->set_userdata('contactAdded', '1');
            return true;
        }else{
            return false;
        }
        
    }

}

?>