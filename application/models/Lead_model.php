<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_model extends MY_Model {

    public $_table_name;
    public $_table_property = 'Property';
    public $_table_property_images = 'PropertyImages';
    protected $_order_by;
    public $_primary_key;
    public $rules = array(
    );

    function saveLead($data) {
        if (isset($data["Id"]) && !empty($data["Id"])) {
            $leadID = $data["Id"];
            unset($data["Id"]);
            unset($data["CreatedBy"]);
            $this->db->where('Id', $leadID);
            $updateLead = $this->db->update('leads', $data);
            if ($updateLead) {
                return array("status" => 1, "data" => $updateLead, "message" => 'success');
            } else {
                return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
            }
        } else {
            $this->db->insert('leads', $data);
            /* $this->db->last_query(); */
            $leadsId = $this->db->insert_id();
            if ($leadsId) {
                return array("status" => 1, "data" => $leadsId, "message" => 'success');
            } else {
                return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
            }
        }
    }
	//asssign user data insert into data base:
	function assignUserdataSelect(){
		$this->db->select('AssignedUserId');
		$this->db->where('AssignedUserId',1);
		$query = $this->db->get('leads');
		$row = $query->row();
		return $row;
		/*$this->db->last_query();*/
		/*$AssignedId = $this->db->insert_id();*/
		
	}
    function saveGmailContact($data) {
        $this->db->insert('gmailcontact', $data);
        return $this->db->insert_id();
    }

    /**
     * checkEmailExists
     * @param $email string  
     * @return false|true
     */
    function checkLeadEmailExists($data) {

        $this->db->select();
        $this->db->where(array('CreatedBy' => $data['UserId'], 'Email' => $data['Email']));
        $query = $this->db->get('leads');
        $row = $query->row();
        return $row;
    }

    function checkGoogleEmailExists($data) {

        $this->db->select();
        $this->db->where(array('UserId' => $data['UserId'], 'Email' => $data['Email']));
        $query = $this->db->get('gmailcontact');
        $row = $query->row();
        return $row;
    }

    public function getGoogleContactSuggetion() {
        $this->db->select();
        $this->db->where(array('UserId' => $this->session->userdata('id'), 'AddSystemOff' => 0));
        $query = $this->db->get('gmailcontact');
        $this->db->order_by('Email');
        $suggetedContact = array();
        foreach ($query->result() as $row) {
            array_push($suggetedContact, $row);
        }
        return $suggetedContact;
    }

    /*  import contact from csv files */

    function saveLeadAllContactCsv($data) {
        $this->db->insert('leads', $data);
        $leadsId = $this->db->insert_id();
        if ($leadsId) {
            return array("status" => 1, $keys = $values, "data" => $leadsId, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    public function getRecenetLeads() {
        /* $this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName,l.CreatedAt as leadCreatedAt,u.ProfileImage as userImage,NOW() as currentTime');
          $this->db->from('leads l');
          $this->db->join('users as u','u.Id = l.ClientId');
          $this->db->where('l.IsDeleted','1');
          $this->db->order_by('l.CreatedAt','desc');
          $query = $this->db->get(); */
		$id = $this->session->userdata('id');
        $this->db->query("SET @sec := ''");
        $query = $this->db->query("SELECT  @sec := TIMESTAMPDIFF(SECOND,l.CreatedAt,NOW()) as second,CASE
       WHEN @sec < 60 THEN CONCAT(@sec,' seconds ago')
       WHEN @sec >= 60 AND @sec < 3600 THEN CONCAT(FLOOR(@sec/60),' minutes ago')
       WHEN @sec >= 3600 AND @sec < 86400 THEN CONCAT(FLOOR(@sec/3600),' hours ago')
       WHEN @sec >= 86400 AND @sec < 2592000 THEN CONCAT(FLOOR(@sec/86400),' days ago')
       WHEN @sec >=2592000 AND @sec < 946080000 THEN CONCAT(FLOOR(@sec/2592000),' years ago') END  as elpsadedTime,l.Id,l.Title as leadTitle,CONCAT(l.FirstName,' ',l.LastName) as leadUserName,l.CreatedAt as leadCreatedAt,l.LeadImage as userImage from leads as l LEFT JOIN  users as u ON u.Id = l.ClientId WHERE l.IsDeleted = 1 AND l.CreatedBy = $id ORDER BY l.CreatedAt desc LIMIT 50");
        $recenetLeads = array();
        foreach ($query->result() as $row) {
            array_push($recenetLeads, $row);
        }
        return $recenetLeads;
    }

    public function getHotLeads() {
		$id = $this->session->userdata('id');
        /* $this->db->select('l.Id,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName ,l.CreatedAt as leadCreatedAt,l.LeadImage as userImage');
        $this->db->from('leads l');
        $this->db->join('users as u', 'u.Id = l.ClientId');
        $this->db->where(array('l.LeadStatusId' => '1', 'l.IsDeleted' => '1'));
        $this->db->order_by('l.CreatedAt', 'desc');
        $this->db->limit(50);
        $query = $this->db->get(); */
		$this->db->query("SET @sec := ''");
       $query = $this->db->query("SELECT  @sec := TIMESTAMPDIFF(SECOND,l.CreatedAt,NOW()) as second,CASE
       WHEN @sec < 60 THEN CONCAT(@sec,' seconds ago')
       WHEN @sec >= 60 AND @sec < 3600 THEN CONCAT(FLOOR(@sec/60),' minutes ago')
       WHEN @sec >= 3600 AND @sec < 86400 THEN CONCAT(FLOOR(@sec/3600),' hours ago')
       WHEN @sec >= 86400 AND @sec < 2592000 THEN CONCAT(FLOOR(@sec/86400),' days ago')
       WHEN @sec >=2592000 AND @sec < 946080000 THEN CONCAT(FLOOR(@sec/2592000),' years ago') END  as elpsadedTime,l.Id,l.Title as leadTitle,CONCAT(l.FirstName,' ',l.LastName) as leadUserName,l.CreatedAt as leadCreatedAt,l.LeadImage as userImage from leads as l LEFT JOIN  users as u ON u.Id = l.ClientId WHERE l.IsDeleted = 1 AND  l.LeadStatusId = 1 AND l.CreatedBy = $id ORDER BY l.CreatedAt desc LIMIT 50");
        $hotLeads = array();
        foreach ($query->result() as $row) {
            array_push($hotLeads, $row);
        }
        return $hotLeads;
    }

    public function updateLead($data, $leadId) {
        $this->db->where('Id', $leadId);
        $this->db->update('leads', $data);
        if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    
	public function getAssignedUser()
	{	
//for assigned user:
		$this->db->select('au.Id As AssignedId,CONCAT(au.FirstName," ",au.LastName) As AssignedUser,au.UserName As AssignedUserName,au.CreatedBy');
		$this->db->from('users as au');
		$query1 = $this->db->get();
		$teamMembersAssigned=array();
		foreach ($query1->result() as $row)


		{
			array_push($teamMembersAssigned, $row);
		}

		return $teamMembersAssigned;

	}

	public function getLeadDetailsContact($postData, $itemsPerPage=0, $pageNo=0)
	{ 
			  $this->db->select('l.Id as contactId,l.Title as contactTitle,l.LeadImage as ProfileImage, CONCAT(l.FirstName," ",l.LastName) as contactName,GROUP_CONCAT(DISTINCT (c.Name))AS circlesAll,l.PhoneNo,l.Email,l.CreatedAt, l.AssignedUserId as AssignedUserId');
			  $this->db->from('leads as l','circles as c');
			  $this->db->join('lead_circle as lc', 'l.Id = lc.LeadId','left' );
			  $this->db->join('circles as c', 'c.Id = lc.CircleId','left');
			  
			  $this->db->join('lead_tags as lt', 'lt.LeadId = l.Id','left');
			  $this->db->join('users as u', 'l.AssignedUserId = u.ReferanceId','left');
			  $this->db->where('l.AssignedUserId',$this->session->userdata('id'));

			  if(isset($postData['tag']) && count($postData['tag']) > 0){
			   $this->db->where_in('TagTitle', $postData['tag']);

			  }
			  if(isset($postData['circle']) && count($postData['circle']) > 0){
			   $this->db->where_in('CircleId', $postData['circle']);
			   
			  }
			  if(isset($postData['status']) && count($postData['status']) > 0){
			   $this->db->where_in('LeadStatusId', $postData['status']);
			   
			  }
			  if(isset($postData['user']) && count($postData['user']) > 0){
			   $this->db->where_in('AssignedUserId', $postData['user']);
			   
			  }
			  //$this->db->join('lead_tags as lt', 'lt.LeadId = l.Id');
			  //$this->db->where(array('lc.CreatedBy'=>1)); 
			  $this->db->group_by('l.Id');
			  if($itemsPerPage > 0){
			   $this->db->limit($itemsPerPage, (($pageNo - 1) * $itemsPerPage) ); 
			  }
			  
			  $query = $this->db->get(); 
			  

			  
			  $teamMembers = array();
			  foreach ($query->result() as $row)
			  {
			   array_push($teamMembers, $row);
			  }


			  $this->db->select('COUNT(*) AS totalRecord');
			  $this->db->from('leads as l','circles as c');
			  $this->db->join('lead_circle as lc', 'l.Id = lc.LeadId','left' );
			  $this->db->join('circles as c', 'c.Id = lc.CircleId','left');
			  $this->db->join('lead_tags as lt', 'lt.LeadId = l.Id','left');
			  $this->db->where('l.AssignedUserId',$this->session->userdata('id'));
			  if(isset($postData['tag']) && count($postData['tag']) > 0){
			   $this->db->where_in('TagTitle', $postData['tag']);

			  }
			  if(isset($postData['circle']) && count($postData['circle']) > 0){
			   $this->db->where_in('CircleId', $postData['circle']);
			   
			  }
			  if(isset($postData['status']) && count($postData['status']) > 0){
			   $this->db->where_in('LeadStatusId', $postData['status']);
			   
			  }
			  if(isset($postData['user']) && count($postData['user']) > 0){
			   $this->db->where_in('LeadSourceId', $postData['user']);
			   
			  }
			  $this->db->group_by('l.Id');
			  $total = $this->db->get();

			  $this->db->select('COUNT(*) AS totalRecord');
			  $this->db->from('('.$this->db->last_query().') AS sub'); 
			  $total = $this->db->get();
			  
			  $leadArray = array();
			  $leadArray['data'] = $teamMembers;
			  $leadArray['totalRecord'] = $total->result()[0]->totalRecord;
			  return $leadArray;
		}

    public function getAllContactMergeData() {
        $this->db->select('l.Id as contactId,l.Title as contactTitle,l.Email');
        $this->db->from('leads as l');
        $this->db->where(array('l.CreatedBy' => $this->session->userdata('id'), 'l.ClientId' => 1, 'l.CreatedBy' => 1));
        $query = $this->db->get();

        /* $query = $this->db->query("SELECT l.`Id` AS contactId, l.`FirstName`,GROUP_CONCAT(c.Name)AS circle FROM `leads` as l INNER JOIN lead_circle as lc ON lc.LeadId = l.Id LEFT JOIN circles AS c ON c.Id = lc.CircleId WHERE l.CreatedBy=$this->session->userdata(l.`Id`)"); */
        $DataAllMerge = array();
        foreach ($query->result() as $row) {
            array_push($DataAllMerge, $row);
        }
        //var_dump($teamMembers);
        return $DataAllMerge;
    }

    public function getLeadDetails($leadId) {
        $this->db->select('l.Id,l.SocialProfile,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName ,l.FirstName,l.LastName,l.WebSite, DATE_FORMAT(l.BirthDate, "%m-%d-%Y") as BirthDate,DATE_FORMAT(l.AniversaryDate, "%m-%d-%Y") as AniversaryDate,
		l.AddressLine1,l.AddressLine2,l.City,l.State,l.Zipcode,l.CreatedAt as leadCreatedAt,l.CompanyName as companyName,l.PhoneNo as phoneNo,l.Email as email,l.Location as location,l.Address as address,l.Timezone as timezone,lstu.LeadStatus as leadStatus,ls.LeadSource as leadSource,l.CurrentTranscation as leadTranscation,CONCAT(u.FirstName," ",u.LastName) as leadOwnerName,l.LeadImage as userAvatar,ls.Id leadSourceId,lstu.Id as leadStatusId');
        $this->db->from('leads l');
        $this->db->join('users as u', 'u.ReferanceId = l.ClientId');
        $this->db->join('lead_sources as ls', 'ls.Id = l.LeadSourceId');
        $this->db->join('lead_status as lstu', 'lstu.Id = l.LeadStatusId');
        $this->db->where(array('l.Id' => $leadId, 'l.IsDeleted' => '1'));
        $query = $this->db->get();
		$row = $query->row();
        if (!empty($row)) {
            return array("status" => 1, "data" => $row, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found', 'query' => $this->db->last_query());
        }
    }


    public function getRelatedLeadDropdown($currentLeadId, $searchContactValue) {
        if (!empty($searchContactValue)) {
            $getRelatedIdArray = $this->getRelatedId($currentLeadId);
            $leadIdArray = array();
            $currentLeadIdArray[] = $currentLeadId;
            $leadIdArray = array_merge($getRelatedIdArray, $currentLeadIdArray);
            $this->db->select('l.Id as leadId,CONCAT(l.FirstName," ",l.LastName) as leadUserName, l.Email as leadEmail, l.LeadImage as leadImage');
            $this->db->from('leads as l');
            $this->db->where_not_in('l.Id', $leadIdArray);
            if (isset($searchContactValue) && !empty($searchContactValue)) {
                $this->db->where('(l.FirstName LIKE "%' . $searchContactValue . '%" OR l.LastName LIKE "%' . $searchContactValue . '%" OR l.PhoneNo LIKE "%' . $searchContactValue . '%" OR l.Email LIKE "%' . $searchContactValue . '%" OR CONCAT(l.FirstName," ",l.LastName) LIKE "%' . $searchContactValue . '%")');
                /* $this->db->like('l.FirstName', $searchContactValue);
                  $this->db->or_like('l.LastName', $searchContactValue);
                  $this->db->or_like('l.PhoneNo', $searchContactValue);
                  $this->db->or_like('l.Email', $searchContactValue);
                  $this->db->or_like('CONCAT(l.FirstName," ",l.LastName)', $searchContactValue); */
            }
            $query = $this->db->get();
            $getRelatedLeadDropdown = array();
            foreach ($query->result() as $row) {
                array_push($getRelatedLeadDropdown, $row);
            }
            if (!empty($getRelatedLeadDropdown)) {
                return array("status" => 1, "data" => $getRelatedLeadDropdown, "message" => 'success');
            } else {
                return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
            }
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
        }
    }

    public function getRelatedId($currentLeadId) {
        $this->db->select('RelatedLeadId');
        $this->db->from('related_leads');
        $this->db->where('LeadId', $currentLeadId);
        $query = $this->db->get();
        $relatedLeadId = array();
        foreach ($query->result() as $row) {
            array_push($relatedLeadId, $row->RelatedLeadId);
        }
        $this->db->select('HouseHoldLeadId');
        $this->db->from('household_leads');
        $this->db->where('LeadId', $currentLeadId);
        $query = $this->db->get();
        $housHoldLeadId = array();
        foreach ($query->result() as $row) {
            array_push($housHoldLeadId, $row->HouseHoldLeadId);
        }
        $allRelatedLeads = array_merge($relatedLeadId, $housHoldLeadId);
        return $allRelatedLeads;
    }

    public function getEditRelatedLeadDropdown($currentLeadId) {
        $this->db->select('l.Id as leadId,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
        $this->db->from('leads as l');
        $this->db->join('related_leads rl', 'rl.RelatedLeadId = l.Id');
        $this->db->where('rl.LeadId', $currentLeadId);
        $query = $this->db->get();
        $getRelatedLeadDropdown = array();
        foreach ($query->result() as $row) {
            array_push($getRelatedLeadDropdown, $row);
        }
        if (!empty($getRelatedLeadDropdown)) {
            return array("status" => 1, "data" => $getRelatedLeadDropdown, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
        }
    }

    public function saveRelatedContact($data) {
        $this->db->insert('related_leads', $data);
        $relatedLeadId = $this->db->insert_id();
        if ($relatedLeadId) {
            return array("status" => 1, "data" => $relatedLeadId, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    public function getRelatedContacts($currentLeadId) {
        $this->db->select('rl.Id as relationId,rl.Relation as relationTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
        $this->db->from('related_leads as rl');
        $this->db->join('leads as l', 'l.Id = rl.RelatedLeadId');
        $this->db->where('rl.LeadId', $currentLeadId);
        $query = $this->db->get();
        $getRelatedContacts = array();
        foreach ($query->result() as $row) {
            array_push($getRelatedContacts, $row);
        }
        if (!empty($getRelatedContacts)) {
            return array("status" => 1, "data" => $getRelatedContacts, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
        }
    }

    public function deleteRelatedContact($relationId) {
        $this->db->where('Id', $relationId);
        $this->db->delete('related_leads');
        if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry there is some error');
        }
    }

    public function deleteHouseHoldContact($houseHoldId) {
        $this->db->where('Id', $houseHoldId);
        $this->db->delete('household_leads');
        if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry there is some error');
        }
    }

    public function getRelatedContactById($relationId) {
        $this->db->select('Id as Id,RelatedLeadId as relatedId,Relation as relation');
        $this->db->from('related_leads');
        $this->db->where('Id', $relationId);
        $query = $this->db->get();
        $row = $query->row();
        if (!empty($row)) {
            return array("status" => 1, "data" => $row, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry there is no data found');
        }
    }

    public function updateRelatedContact($data, $editRelationId) {
        $this->db->where('Id', $editRelationId);
        $this->db->update('related_leads', $data);
        if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    public function updateLeadData($data, $leadId) {
        $this->db->where('Id', $leadId);
        $this->db->update('leads', $data);
		if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success', "query" => $this->db->last_query());
			} else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error', "query" => $this->db->last_query());
        }
    }

    public function saveHouseHoldContact($data) {
        $this->db->insert('household_leads', $data);
        $relatedLeadId = $this->db->insert_id();
        if ($relatedLeadId) {
            return array("status" => 1, "data" => $relatedLeadId, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    public function getHouseHoldContacts($currentLeadId) {
        $this->db->select('hl.Id as houseHoldId,hl.Relation as relationTitle,CONCAT(l.FirstName," ",l.LastName) as leadUserName');
        $this->db->from('household_leads as hl');
        $this->db->join('leads as l', 'l.Id = hl.HouseHoldLeadId');
        $this->db->where('hl.LeadId', $currentLeadId);
        $query = $this->db->get();
        $getHouseHoldContacts = array();
        foreach ($query->result() as $row) {
            array_push($getHouseHoldContacts, $row);
        }
        if (!empty($getHouseHoldContacts)) {
            return array("status" => 1, "data" => $getHouseHoldContacts, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
        }
    }

    public function getLeadListDropdown() {
		$userId = $this->session->userdata('id');
        $this->db->select('Id,CONCAT(FirstName," ",LastName) as leadUserName');
        $this->db->from('leads');
        $this->db->where('IsDeleted', 1);
		$where = '(	AssignedUserId='.$userId.' or CreatedBy = '.$userId.')';
		$this->db->where($where);
        $query = $this->db->get();
        $leadDropDown = array();
        foreach ($query->result() as $row) {
            array_push($leadDropDown, $row);
        }
        if (!empty($leadDropDown)) {
            return array("status" => 1, "data" => $leadDropDown, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
        }
    }

    /*  Get all contact in page contact merge */

    public function getContactAllfromLead() {
        $this->db->select('Id,CONCAT(FirstName," ",LastName) as ContactUserName,Email As EmailLead');
        $this->db->from('leads');
        $this->db->where(array('IsDeleted'=>1,'AssignedUserId'=>$this->session->userdata('id')));
        // $this->db->order_by('Email');
        $this->db->order_by('CreatedAt', 'desc');
        $query = $this->db->get();
        $leadDropDown = array();
        foreach ($query->result() as $row) {
            array_push($leadDropDown, $row);
        }
        return $leadDropDown;
    }

    /* Get All Circles data to show individual circles for Export CSV Popup Box. */

    public function getCircleForExportCSV() {
        $this->db->select('Name');
        $this->db->from('circles');
        $query = $this->db->get();
        /* var_dump($this->db->last_query(),$query->result());
          die; */
        $getCircle = array();
        foreach ($query->result() as $row) {
            array_push($getCircle, $row);
        }
        return $getCircle;
    }

    public function getInteractionTypesDropdown() {
        $this->db->select(array('Id as interactionTypeId', 'Title as interactionTypeTitle'));
        $this->db->from('lead_interaction_types');
        $this->db->where(array('IsDeleted' => 1, 'Status' => 1));
        $interactionTypesData = $this->db->get();
        $interactionDropDown = array();
        foreach ($interactionTypesData->result() as $row) {
            array_push($interactionDropDown, $row);
        }
        if (!empty($interactionDropDown)) {
            return array("status" => 1, "data" => $interactionDropDown, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
        }
    }

    public function saveLeadInteraction($data) {
        $this->db->insert('lead_interactions', $data);
        $interactonLeadId = $this->db->insert_id();
        if ($interactonLeadId) {
            return array("status" => 1, "data" => $interactonLeadId, "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    public function getLeadDataByLeadId($leadId) {
        $this->db->select('*,DATE_FORMAT(Birthdate,"%m-%d-%Y") as leadBirthDate,DATE_FORMAT(AniversaryDate,"%m-%d-%Y") as leadAniversaryDate');
        $this->db->from('leads');
        $this->db->where(array('IsDeleted' => 1, 'Id' => $leadId));
        $leadData = $this->db->get();
		
		$this->db->select('TagTitle');
		$this->db->from('lead_tags');
		$this->db->where('LeadId',$leadId);
		$tagsData = $this->db->get();
		if ($leadData->num_rows() > 0) {
			$resultData = array();
			$resultData['leadData'] = $leadData->row();
			$resultData['tagData'] = $tagsData->result();
            if (!empty($leadData->row())) {
                return array("status" => 1, "data" => $resultData['leadData'], "leadData" => $resultData['tagData'], "message" => 'success');
            } else {
                return array("status" => 0, "data" => '', "message" => 'Sorry no data found');
            }
        }
    }

	public function getImageNameByLeadId($leadId){
	  if(isset($leadId) && !empty($leadId))
	  {
	   $this->db->select('LeadImage');
	   $this->db->from('leads');
	   $this->db->where('Id',$leadId);
	   $leadImage = $this->db->get();
	   return $leadImage->row()->LeadImage;
	  }
	 }
 	
	/* Update The Assignee of a lead */
	public function updateAssignee($postData)
	{	
		$this->db->where('Id',$postData['contactId']);
		$this->db->update('leads', array("AssignedUserId" => $postData['AssignedUserId'])); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}

	public function getLatestAnalytics()
    {  
		$userId = $this->session->userdata('id');
        $this->db->select('DATE_FORMAT(CreatedAt,"%b%d") as created,COUNT(*) as total');
        $this->db->from('leads');
		$where = '(AssignedUserId='.$userId.' or CreatedBy = '.$userId.')';
		$this->db->where($where);
		$this->db->group_by('date(CreatedAt)');
        $this->db->order_by('date(CreatedAt)');
        $queryanalytics = $this->db->get();
        $latestAnalytics=array();
        foreach ($queryanalytics->result() as $row)
        {
            array_push($latestAnalytics, $row);
        }
        return $latestAnalytics;
    }
        public function getLeadUser($para=null){
			$userId = $this->session->userdata('id');
            if(!empty($para) && $para=='gmail')
                $this->db->select('GROUP_CONCAT(DISTINCT(Email)) as Email');
            else    
            {
                if(!empty($para))
                $this->db->where($para);
                $this->db->select('Id,FirstName,LastName,Email');
            }

            $this->db->from('leads');	
            $this->db->where('IsDeleted',1);
            $where = '(AssignedUserId='.$userId.' or CreatedBy = '.$userId.')';
			$this->db->where($where);
            $query = $this->db->get();
            $leadUsers = array();
            foreach ($query->result() as $row)
            {
                    array_push($leadUsers, $row);
            }
            return $leadUsers;		
        }

    public function saveMergeFromGoogle($data, $leadId) {
        if(is_array($data)){
            $data = json_encode($data);
        }
        $this->db->where('Id', $leadId);
        $this->db->update('leads', ['MergeFromGoogle' => $data]);
        if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }
    public function changeStatusGoogleContact($gmailcontactId, $status){
        $this->db->where('Id', $gmailcontactId);
        $this->db->update('gmailcontact', ['AddSystemOff' => $status]);
        if ($this->db->affected_rows() > 0) {
            return array("status" => 1, "data" => $this->db->affected_rows(), "message" => 'success');
        } else {
            return array("status" => 0, "data" => '', "message" => 'Sorry There is some error');
        }
    }

    public function getRepresentedProperties(){
        $propertydb = $this->load->database('property_db', TRUE);
        $propertydb->select('*');
        $propertydb->from($this->_table_property);
        $propertydb->where('IsDeleted','0');
        $propertydb->limit(5);
        $query = $propertydb->get();
        $representedProperties = $query->result();
        $i= 0;
        if(!empty($representedProperties)){
            foreach ($representedProperties as $row) {
                $MlsId = $row->MlsId;
                $image_query = $propertydb->select('ImageUrl')
                ->from($this->_table_property_images)
                ->where('MlsId',$MlsId)
                ->limit('1')
                ->get();
                $result = $image_query->row_array();
                $ImageUrl = $result['ImageUrl'];
                $row->ImageUrl = $ImageUrl;
                $i++;
            }
        }
        return $representedProperties;
    }

    public function getSavedProperties(){
        $propertydb = $this->load->database('property_db', TRUE);
        $propertydb->select('*');
        $propertydb->from($this->_table_property);
        $propertydb->where('IsDeleted','0');
        $propertydb->limit(5);
        $query = $propertydb->get();
        $representedProperties = $query->result();
        $i= 0;
        if(!empty($representedProperties)){
            foreach ($representedProperties as $row) {
                $MlsId = $row->MlsId;
                $image_query = $propertydb->select('ImageUrl')
                ->from($this->_table_property_images)
                ->where('MlsId',$MlsId)
                ->limit('1')
                ->get();
                $result = $image_query->row_array();
                $ImageUrl = $result['ImageUrl'];
                $row->ImageUrl = $ImageUrl;
                $i++;
            }
        }
        return $representedProperties;
    }
}

