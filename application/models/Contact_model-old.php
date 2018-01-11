<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_model extends MY_Model {
	public $_table_name;
    protected $_order_by;
    public $_primary_key;
    public $rules = array(
    
	);
	
	function saveLead($data)
	{
		var_dump('hello');
		$this->db->insert('leads', $data);
		$leadsId = $this->db->insert_id();
		if($leadsId)
		{
			return array("status"=>1,"data"=>$leadsId,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getRecenetLeads()
	{
		/* $this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName,l.CreatedAt as leadCreatedAt,u.ProfileImage as userImage,NOW() as currentTime');
		$this->db->from('leads l'); 
		$this->db->join('users as u','u.Id = l.ClientId');
		$this->db->where('l.IsDeleted','1');
		$this->db->order_by('l.CreatedAt','desc');
		$query = $this->db->get(); */
		$this->db->query("SET @sec := ''");
	    $query = $this->db->query("SELECT  @sec := TIMESTAMPDIFF(SECOND,l.CreatedAt,NOW()) as second,CASE
       WHEN @sec < 60 THEN CONCAT(@sec,' seconds ago')
       WHEN @sec >= 60 AND @sec < 3600 THEN CONCAT(FLOOR(@sec/60),' minutes ago')
       WHEN @sec >= 3600 AND @sec < 86400 THEN CONCAT(FLOOR(@sec/3600),' hours ago')
       WHEN @sec >= 86400 AND @sec < 2592000 THEN CONCAT(FLOOR(@sec/86400),' days ago')
       WHEN @sec >=2592000 AND @sec < 946080000 THEN CONCAT(FLOOR(@sec/2592000),' years ago') END  as elpsadedTime,l.Id,l.Title as leadTitle,CONCAT(l.FirstName,' ',l.LastName) as leadUserName,l.CreatedAt as leadCreatedAt,u.ProfileImage as userImage from leads as l LEFT JOIN  users as u ON u.Id = l.ClientId WHERE l.IsDeleted = 1 ORDER BY l.CreatedAt desc LIMIT 3");
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
		$this->db->limit(3);
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
		$this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName ,l.CreatedAt as leadCreatedAt,l.CompanyName as companyName,l.PhoneNo as phoneNo,l.Email as email,l.Location as location,l.Address as address,l.Timezone as timezone,lstu.LeadStatus as leadStatus,ls.LeadSource as leadSource,l.CurrentTranscation as leadTranscation,CONCAT(u.FirstName," ",u.LastName) as leadOwnerName,u.ProfileImage as userAvatar,ls.Id leadSourceId,lstu.Id as leadStatusId');
		$this->db->from('leads l'); 
		$this->db->join('users as u','u.Id = l.ClientId');
		$this->db->join('lead_sources as ls','ls.Id = l.LeadSourceId');
		$this->db->join('lead_status as lstu','lstu.Id = l.LeadStatusId');
		$this->db->where(array('l.Id'=>$leadId,'l.IsDeleted'=>'1'));
		$query = $this->db->get();
		$row = $query->row();
		if(!empty($row))
		{
			return array("status"=>1,"data"=>$row,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}
    public function getRelatedLeadDropdown($currentLeadId)
	{
	
		$getRelatedIdArray = $this->getRelatedId($currentLeadId);
		$leadIdArray = array();
		$currentLeadIdArray[]= $currentLeadId;
		$leadIdArray = array_merge($getRelatedIdArray,$currentLeadIdArray);
		$this->db->select('l.Id as leadId,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
		$this->db->from('leads as l'); 
		$this->db->where_not_in('l.Id',$leadIdArray);
		$query = $this->db->get();
		$getRelatedLeadDropdown = array();
		foreach ($query->result() as $row)
		{
				array_push($getRelatedLeadDropdown, $row);
		}
		if(!empty($getRelatedLeadDropdown))
		{
			return array("status"=>1,"data"=>$getRelatedLeadDropdown,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
		
	}
	public function getRelatedId($currentLeadId)
	{
		$this->db->select('RelatedLeadId'); 
		$this->db->from('related_leads'); 
		$this->db->where('LeadId',$currentLeadId);
		$query = $this->db->get();
		$relatedLeadId = array();
		foreach ($query->result() as $row)
		{
				array_push($relatedLeadId, $row->RelatedLeadId);
		}
		$this->db->select('HouseHoldLeadId'); 
		$this->db->from('household_leads'); 
		$this->db->where('LeadId',$currentLeadId);
		$query = $this->db->get();
		$housHoldLeadId = array();
		foreach ($query->result() as $row)
		{
				array_push($housHoldLeadId, $row->HouseHoldLeadId);
		}
		$allRelatedLeads = array_merge($relatedLeadId,$housHoldLeadId);
		return $allRelatedLeads;
	}
	public function getEditRelatedLeadDropdown($currentLeadId)
	{
		$this->db->select('l.Id as leadId,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
		$this->db->from('leads as l'); 
		$this->db->join('related_leads rl','rl.RelatedLeadId = l.Id');
		$this->db->where('rl.LeadId',$currentLeadId);
		$query = $this->db->get();
		$getRelatedLeadDropdown = array();
		foreach ($query->result() as $row)
		{
				array_push($getRelatedLeadDropdown, $row);
		}
		if(!empty($getRelatedLeadDropdown))
		{
			return array("status"=>1,"data"=>$getRelatedLeadDropdown,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}
	public function saveRelatedContact($data)
	{
		$this->db->insert(' related_leads', $data);
		$relatedLeadId = $this->db->insert_id();
		if($relatedLeadId)
		{
			return array("status"=>1,"data"=>$relatedLeadId,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getRelatedContacts($currentLeadId)
	{
		$this->db->select('rl.Id as relationId,rl.Relation as relationTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
		$this->db->from('related_leads as rl'); 
		$this->db->join('leads as l','l.Id = rl.RelatedLeadId');
		$this->db->where('rl.LeadId',$currentLeadId);
		$query = $this->db->get();
		$getRelatedContacts = array();
		foreach ($query->result() as $row)
		{
				array_push($getRelatedContacts, $row);
		}
		if(!empty($getRelatedContacts))
		{
			return array("status"=>1,"data"=>$getRelatedContacts,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}	
	}
	public function deleteRelatedContact($relationId)
	{
		$this->db->where('Id', $relationId);
		$this->db->delete('related_leads'); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry there is some error');
		}
	}
	public function deleteHouseHoldContact($houseHoldId)
	{
		$this->db->where('Id', $houseHoldId);
		$this->db->delete('household_leads'); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry there is some error');
		}
	}
	public function getRelatedContactById($relationId)
	{
		$this->db->select('Id as Id,RelatedLeadId as relatedId,Relation as relation');
		$this->db->from('related_leads'); 
		$this->db->where('Id',$relationId); 
		$query = $this->db->get();
		$row = $query->row();
		if(!empty($row))
		{
			return array("status"=>1,"data"=>$row,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry there is no data found');
		}
	}
	public function updateRelatedContact($data,$editRelationId)
	{
		$this->db->where('Id',$editRelationId);
		$this->db->update('related_leads', $data); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function updateLeadData($data,$leadId)
	{
		$this->db->where('Id',$leadId);
		$this->db->update('leads', $data); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success',"query"=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error',"query"=>$this->db->last_query());
		}
	}
	public function saveHouseHoldContact($data)
	{
		$this->db->insert('household_leads', $data);
		$relatedLeadId = $this->db->insert_id();
		if($relatedLeadId)
		{
			return array("status"=>1,"data"=>$relatedLeadId,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getHouseHoldContacts($currentLeadId)
	{
		$this->db->select('hl.Id as houseHoldId,hl.Relation as relationTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
		$this->db->from('household_leads as hl'); 
		$this->db->join('leads as l','l.Id = hl.HouseHoldLeadId');
		$this->db->where('hl.LeadId',$currentLeadId);
		$query = $this->db->get();
		$getHouseHoldContacts = array();
		foreach ($query->result() as $row)
		{
				array_push($getHouseHoldContacts, $row);
		}
		if(!empty($getHouseHoldContacts))
		{
			return array("status"=>1,"data"=>$getHouseHoldContacts,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}
	public function getLeadListDropdown()
	{
		$this->db->select('Id,CONCAT(FirstName," ",LastName) as leadUserName');
		$this->db->from('leads');	
		$this->db->where('IsDeleted',1);
		$query = $this->db->get();
		$leadDropDown = array();
		foreach ($query->result() as $row)
		{
				array_push($leadDropDown, $row);
		}
		if(!empty($leadDropDown))
		{
			return array("status"=>1,"data"=>$leadDropDown,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}

}
?>