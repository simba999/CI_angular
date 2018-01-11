<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Interaction_model extends MY_Model {
	
	public $_table_name = 'lead_interactions';
    protected $_order_by;
    public $_primary_key;
	public $collection;
    public $rules = array(
    );
	
	function saveInteraction($data)
	{
		$this->db->insert($this->_table_name,$data);
		$taskId = $this->db->insert_id();
		if($taskId)
		{
			return array("status"=>1,"data"=>$taskId,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error please try again later');
		}
	}
	public function searchInteractions($searchCriteria)
	{
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lt.LeadId'=>$searchCriteria['leadId']));
		if(isset($searchCriteria['searchInteractionDate']))
		{
			$searchDate = explode('|',$searchCriteria['searchInteractionDate']);
			$this->db->where(array('lt.InteractionDate >= '=>$searchDate['0'],'lt.InteractionDate  <= '=>$searchDate['1']));
			
		}
		if(isset($searchCriteria['searchInteractionTitle']))
		{
			$this->db->like('lt.Title',$searchCriteria['searchInteractionTitle'],'after');
		}
		$this->db->order_by('lt.InteractionDate','desc');
		$query = $this->db->get();
		$interactions = array();
		foreach ($query->result() as $row)
		{
			array_push($interactions, $row);
		}
		if(!empty($interactions))
		{
			//return array("status"=>1,"data"=>$interactions,"message"=>'success',"Query"=>$this->db->last_query());
			return array("status"=>1,"data"=>$interactions,"message"=>'success',"Query"=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found',"Query"=>$this->db->last_query());
		}
		
	}
	public function getAllInteractions($interactionTypeId,$currentLeadId,$searchInteractionDate,$searchInteractionTitle)
	{
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,l.LeadImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.ReferanceId = lt.CreatedBy');
		if($interactionTypeId)
		{
			$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>$interactionTypeId,'lt.LeadId'=>$currentLeadId));
		}
		else
		{
			$this->db->where(array('lt.IsDeleted'=>'1','lt.LeadId'=>$currentLeadId));
		}
		if(!empty($searchInteractionDate))
		{
			//$this->db->where(array('lt.InteractionDate'=>$searchInteractionDate));
			$searchDate = explode('|',$searchCriteria['searchInteractionDate']);
			$this->db->where(array('lt.InteractionDate >= '=>$searchDate['0'],'lt.InteractionDate  <= '=>$searchDate['1']));
		}
		if(!empty($searchInteractionTitle))
		{
			$this->db->like('lt.Title',$searchInteractionTitle,'after');
		}
		$this->db->order_by('lt.InteractionDate','desc');
		$query = $this->db->get();
		$interactions = array();
		foreach ($query->result() as $row)
		{
			array_push($interactions, $row);
		}
		/* $this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>'2'));
		$query = $this->db->get();
		$interactions = array();
		$callInteractions = array();
		foreach ($query->result() as $row)
		{
			array_push($callInteractions, $row);
		}
		$interactions['callInteractions'] = $callInteractions;
		// Calender 
		
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>'1'));
		$query = $this->db->get();
		$calenderInteractions = array();
		foreach ($query->result() as $row)
		{
			array_push($calenderInteractions, $row);
		}
		$interactions['calenderInteractions'] = $calenderInteractions;
		
		// Note
		
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>'4'));
		$query = $this->db->get();
		$noteInteractions = array();
		foreach ($query->result() as $row)
		{
			array_push($noteInteractions, $row);
		}
		$interactions['noteInteractions'] = $noteInteractions;
		
		// Text
		
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>'5'));
		$query = $this->db->get();
		$textInteractions = array();
		foreach ($query->result() as $row)
		{
			array_push($textInteractions, $row);
		}
		$interactions['textInteractions'] = $textInteractions;
		// In Person
		
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>'6'));
		$query = $this->db->get();
		$inPersonInteractions = array();
		foreach ($query->result() as $row)
		{
			array_push($inPersonInteractions, $row);
		}
		$interactions['inPersonInteractions'] = $inPersonInteractions;
		
		// Print-Marketing
		
		$this->db->select('lt.Id as interactionId,lt.Title as interactionTitle,lt.LeadId as leadId, DATE_FORMAT(lt.InteractionDate,"%M %d %Y") as interactionDate,CONCAT(l.FirstName," ",l.LastName) as leadUserName,u.ProfileImage as userImage,lit.Title as interactionType,lit.Icon as interactionTypeIcon');
		$this->db->from('lead_interactions as lt');   
		$this->db->join('lead_interaction_types as lit','lit.Id = lt.InteractionTypeId');	
		$this->db->join('leads as l','l.Id = lt.LeadId');	
		$this->db->join('users as u','u.Id = l.CreatedBy');
		$this->db->where(array('lt.IsDeleted'=>'1','lit.Id'=>'7'));
		$query = $this->db->get();
		$printMarketingInteractions = array();
		foreach ($query->result() as $row)
		{
			array_push($printMarketingInteractions, $row);
		}
		$interactions['printMarketingInteractions'] = $printMarketingInteractions;
		
		$allInteraction = array_merge($callInteractions,$calenderInteractions,$noteInteractions,$textInteractions,$inPersonInteractions,$printMarketingInteractions);
		$interactions['allInteraction'] = $allInteraction; */
		return $interactions;
	}
	
}
?>