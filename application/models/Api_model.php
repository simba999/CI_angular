<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 0);
class Api_model extends MY_Model {

    public $_property_table_name = 'Property';
    public $_lead_table = 'leads';
    public $_event_table = 'events';
	
	 function getLeadDataBySearch($searchKeyWord,$userId)
	 {
			$this->db->select('l.Id as leadId,CONCAT(l.FirstName," ",l.LastName) as leadUserName, l.Email as leadEmail, l.LeadImage as leadImage,l.Title as leadTitle');
            $this->db->from($this->_lead_table.'  as l');
            if (isset($searchKeyWord) && !empty($searchKeyWord)) {
                $this->db->where('(l.FirstName LIKE "%' . $searchKeyWord . '%" OR l.LastName LIKE "%' . $searchKeyWord . '%" OR l.PhoneNo LIKE "%' . $searchKeyWord . '%" OR l.Email LIKE "%' . $searchKeyWord . '%" OR CONCAT(l.FirstName," ",l.LastName) LIKE "%' . $searchKeyWord . '%" OR l.CompanyName LIKE "%'.$searchKeyWord.'%")');
            }
			$where = '(	AssignedUserId='.$userId.' or CreatedBy = '.$userId.')';
			$this->db->where($where);
			$query = $this->db->get();
			$leadDetails = array();
			foreach ($query->result() as $row) {
				array_push($leadDetails, $row);
			}
			return $leadDetails;
	}
	 function getAllProperty($searchKeyWord,$userId)
	{
			$propertydb = $this->load->database('property_db', TRUE);
			$propertydb->select('*');
			 $propertydb->from($this->_property_table_name);
			if (isset($searchKeyWord) && !empty($searchKeyWord)) {
                $propertydb->where('(AddressCrossStreet LIKE "%' . $searchKeyWord . '%" OR AddressState LIKE "%' . $searchKeyWord . '%" OR AddressCountry LIKE "%' . $searchKeyWord . '%" OR AddressStreetName LIKE "%' . $searchKeyWord . '%" OR AddressCity LIKE "%' . $searchKeyWord . '%" OR AddressFull LIKE "%'.$searchKeyWord.'%")');
            }
			$query = $propertydb->get();
			$propertyDetails = array();
			foreach ($query->result() as $row) {
				array_push($propertyDetails, $row);
			}
			return $propertyDetails;
	}
	function getAllEvents($searchKeyWord,$userId){
		
		$this->db->select('e.id,e.eventTitle as title,e.eventDescription as description,TIMESTAMP(e.eventStartDate,e.eventStartTime) as start,TIMESTAMP(e.eventEndDate,e.eventEndTime) as end,e.location as location,e.hostName as host,e.eventImage as eventImage,e.eventStartTime as eventStartTime,e.eventEndTime as eventEndTime,c.name as calenderName,c.color as eventColor,e.creatorId as owner');
		$this->db->from($this->_event_table.' as e');	
		$this->db->join('calendars as c','c.Id = e.calenderType');
		$this->db->where(array('e.creatorId'=>$userId,'CalanderType'=>1,'e.eventTitle LIKE "%'.$searchKeyWord.'"'));
		$query = $this->db->get();
		$eventDetails = array();
			foreach ($query->result() as $row) {
				array_push($eventDetails, $row);
			}
		return $eventDetails;
			
	}
	
}
?>