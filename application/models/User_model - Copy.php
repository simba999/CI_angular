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
		foreach ($query->result() as $row)
		{
			array_push($assignUsers, $row);
			}
		return $assignUsers;
	}
	public function getAssignUsersForEmailMsg()
	{ 	
		$this->db->from('users');  
		$this->db->select('*');
		/*echo json_encode($this->session->all_userdata());
		die;*/
		
		if($this->session->userdata('roleId') == 4) {
			$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'Status'=>1,'RoleId'=>5));
		} else {
			$this->db->where(array('Id'=>$this->session->userdata('created_by'),'Status'=>1));
		}
		return $this->db->get()->result_array();;
		
		$userdata=$queryParent->result();
		$this->db->from('users');  
		$this->db->select('Id,FirstName,LastName,Email,CreatedBy');
		$this->db->where(array('CreatedBy'=>$this->session->userdata('CreatedBy'),'Status'=>1, 'RoleId'=>5 ));	
		
		$query = $this->db->get();
		$assignUsersForEmailMsg = array();
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