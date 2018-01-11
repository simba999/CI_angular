<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leaddocument_model extends MY_Model {
	
	public $_table_name = 'lead_documents';
    protected $_order_by;
    public $_primary_key;
    public $rules = array(
    );
	
	public function saveDocuments($data)
	{
		$this->db->insert($this->_table_name, $data);
		$documentId = $this->db->insert_id();
		if($documentId)
		{
			return array("status"=>1,"data"=>$documentId,"message"=>'success','query'=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error','query'=>$this->db->last_query());
		}
	}
	public function checkTagExists($data)
	{
		$this->db->select("TagTitle");
		$this->db->from($this->_table_name); 
		$this->db->where(array('LeadId'=>$data['LeadId'],'TagTitle'=>$data['TagTitle']));
		$query = $this->db->get();
		$row = $query->row();
		if(!empty($row))
		{
			return array("status"=>0,"data"=>$row,"message"=>'Tag is already exists for current lead');
		}
		else
		{
			return array("status"=>1,"data"=>$row,"message"=>'success','query'=>$this->db->last_query());
		}
	}
	public function getDocuments($leadId)
	{
		
		$this->db->distinct();
		$this->db->select("Id,LeadId,DocumentPath,OriginalDocumentPath");
		$this->db->from($this->_table_name); 
		$this->db->where('LeadId', $leadId);
		$query = $this->db->get();
		$documents = array();
		foreach ($query->result() as $row)
		{
				array_push($documents, $row);
		}
		if(!empty($documents))
		{
			return array("status"=>1,"data"=>$documents,"message"=>'success','query'=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}
	public function getDocumentById($documentId)
	{
		$this->db->select("Id,DocumentPath,LeadId");
		$this->db->from($this->_table_name); 
		$this->db->where('Id', $documentId);
		$query = $this->db->get();
		$documents = $query->row();
		if(!empty($documents))
		{
			return array("status"=>1,"data"=>$documents,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}	
	}
	public function deleteDocument($leadDocumentId)
	{
		$this->db->where('Id', $leadDocumentId);
		$this->db->delete($this->_table_name); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry there is some error');
		}	
	}
    	
}
?>