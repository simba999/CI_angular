<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leadcircle_model extends MY_Model {
	
	public $_table_name = 'lead_circles';
    protected $_order_by;
    public $_primary_key;
    public $rules = array(
    );
	
	public function saveCircle($data)
	{
		$this->db->insert($this->_table_name, $data);
		$circleId = $this->db->insert_id();
		if($circleId)
		{
			return array("status"=>1,"data"=>$circleId,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getRecenetLeads()
	{
		$this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName,l.CreatedAt as leadCreatedAt,u.ProfileImage as userImage');
		$this->db->from('leads l'); 
		$this->db->join('users as u','u.Id = l.ClientId');
		$this->db->where('l.IsDeleted','1');
		$this->db->order_by('l.CreatedAt','desc');
		$query = $this->db->get();
		$recenetLeads = array();
		foreach($query->result() as $row)
		{
			array_push($recenetLeads, $row);
		}
		return $recenetLeads;
	}
	public function getHotLeads()
	{
		$this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName ,l.CreatedAt as leadCreatedAt,u.ProfileImage as userImage');
		$this->db->from('leads l'); 
		$this->db->join('users as u','u.Id = l.ClientId');
		$this->db->where(array('l.LeadStatusId'=> '1','l.IsDeleted'=>'1'));
		$this->db->order_by('l.CreatedAt','desc');
		$query = $this->db->get();
		$hotLeads = array();
		foreach ($query->result() as $row)
		{
				array_push($hotLeads, $row);
		}
		return $hotLeads;
	}
	public function updateLead($data,$leadId)
	{
		$this->db->where('Id',$leadId);
		$this->db->update('leads', $data); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getLeadDetails($leadId)
	{
		$this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName ,l.CreatedAt as leadCreatedAt,l.CompanyName as companyName,l.PhoneNo as phoneNo,l.Email as email,l.Location as location,l.Address as address,l.Timezone as timezone,lstu.LeadStatus as leadStatus,ls.LeadSource as leadSource,l.CurrentTranscation as leadTranscation,CONCAT(u.FirstName," ",u.LastName) as leadOwnerName,u.ProfileImage as userAvatar');
		$this->db->from('leads l'); 
		$this->db->join('users as u','u.Id = l.ClientId');
		$this->db->join('lead_sources as ls','ls.Id = l.LeadSourceId');
		$this->db->join('lead_status as lstu','lstu.Id = l.LeadStatusId');
		$this->db->where(array('l.Id'=>$leadId,'l.IsDeleted'=>'1'));
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}
    	
}
?>