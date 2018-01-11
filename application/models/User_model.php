<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends MY_Model {
	
	public $_table_name;
    protected $_order_by;
    public $_primary_key;
	public $collection;
    public $rules = array(
    );
	
	function saveUser($data)
	{
		$this->db->insert('users',$data);
		$userId = $this->db->insert_id();
		if($userId)
		{
			return array("status"=>1,"data"=>$userId,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}

	function updateUserImage($userId, $image) {
		return $image;
		// $this->db->where('id', $userId);
		// $this->db->update('ProfileImage', $image);

	}

	/**
	* @deprecated since 1.0.0
	*/
	public function getAssignUsers()
	{
		$this->db->from('users');  
		$this->db->select('Id,FirstName,LastName,Email');
		$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'Status'=>1,'RoleId'=>5));
		$query = $this->db->get();
		$assignUsers = array();
		$seflUser = array();
		$seflUser->Id = $this->session->userdata('id');
		$seflUser->FirstName = $this->session->userdata('FirstName');
		$seflUser->LastName = $this->session->userdata('LastName');
		$seflUser->Email = $this->session->userdata('Email');
		array_push($assignUsers, $seflUser);
		foreach ($query->result() as $row)
		{
			array_push($assignUsers, $row);
		}
		return $assignUsers;
	}
	public function getAssignUsersForEmailMsg()
	{ 	
		
		$this->db->from('users');  
		$this->db->select('ReferanceId as Id,FirstName,LastName,Email,CreatedBy');
		if($this->session->userdata('roleId') == 4) {
			$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'Status'=>1,'RoleId'=>5));
		} /* else {
			$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'Status'=>1));
		} */
		$query = $this->db->get();
		$assignUsersForEmailMsg = array();
		$seflUser = array();
		$seflUser['Id'] = $this->session->userdata('id');
		$seflUser['FirstName'] = $this->session->userdata('firstName');
		$seflUser['LastName'] = $this->session->userdata('lastName');
		$seflUser['Email'] = $this->session->userdata('email'); 
		$seflUser['UserName'] = $this->session->userdata('firstName')." ".$this->session->userdata('lastName'); 
		array_push($assignUsersForEmailMsg, $seflUser);
		foreach ($query->result() as $row)
		{
			array_push($assignUsersForEmailMsg, $row);
		}
		
		return $assignUsersForEmailMsg;
	}

	public function getTeamMember()
	{
		$this->db->from('users');  
		$this->db->select('Id,concat(FirstName," ",LastName) as userName,ProfileImage');
		$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'Status'=>1,'RoleId'=>5));	
		$query = $this->db->get();
		$teamMembers = array();
		foreach ($query->result() as $row)
		{
			array_push($teamMembers, $row);
		}
		return $teamMembers;	
	}

	/*public function getTeamMemberForContact()
	{
		$this->db->from('users');  
		$this->db->select('Id,concat(FirstName," ",LastName) as userName,ProfileImage');
		$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'Status'=>1,'RoleId'=>5));	
		$query = $this->db->get();
		$teamMembers = array();
		foreach ($query->result() as $row)
		{
			array_push($teamMembers, $row);
		}
		return $teamMembers;	
	}*/

}
?>