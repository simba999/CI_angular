<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends MY_Model {

    public $_table_header = 'message_header';
    public $_table_message = 'message';
    public $_table_user = 'users';
    
    function __construct() {
        parent::__construct();
    }

    public function createMessage($data) {
        
		$this->db->insert($this->_table_header, $data);	
		$header_id = $this->db->insert_id();
		if ($header_id) {
			return array("status" =>1,"data" =>$header_id, "message" =>'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }
	public function messageContent($data)
	{
		$this->db->insert($this->_table_message,$data);
		$messageId = $this->db->insert_id();
        if ($messageId) {
			
            return array("status"=>1, "data"=>$messageId,"message"=>'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
	}
    public function inbox() {
        $this->db->where(array('ToId' => 1, 'ToDeleted' => 0, 'Status' => 'sent'));
        $query = $this->db->get($this->_table_header);
        $result = $query->result_array();
        return $result;

    }
    public function updateReadStatus($data,$where){
        $this->db->where($where);
        $this->db->update($this->_table_header,$data);
        $affected=$this->db->affected_rows();
        if ($affected) {
	    return array("status"=>1, "data"=>$affected,"message"=>'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }
    public function addFlagForFirstMessage(){
        $this->db->set('FirstMessageSent',1);
        $this->db->where('ReferanceId', $this->session->userdata('id'));
        $this->db->update($this->_table_user);
        $affected = $this->db->affected_rows();
        if ($affected) {
            $this->session->set_userdata('firstMessageSent', '1');
            return array("status"=>1, "data"=>$affected,"message"=>'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

}

?>