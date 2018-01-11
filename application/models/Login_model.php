<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends MY_Model {
	
	public $_table_name;
    protected $_order_by;
    public $_primary_key;
    public $rules = array(
        'user_name' => array(
            'field' => 'username',
            'label' => 'User Name',
            'rules' => 'trim|required'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    );
	
	function login()
	{
			$user =  $this->db->get_where('users', array('UserName' => $this->input->post('username'),'Password'=>$this->hash($this->input->post('password'))))->row();
			$data = array();
			if(!empty($user) && $user->Status == 1)
			{
				
				$data = array(
				'username' => $user->UserName,
				'email' => $user->Email,
				'id' => $user->Id,
				'loggedin' => TRUE,
				'roleId' => $user->RoleId,
				'status' => $user->Status,
				'user_fullname' => $user->FirstName." ".$user->LastName,
				'user_profile' => $user->ProfileImage,
				'created_by' => $user->CreatedBy,
				'emailConnect' =>$user->EmailConnect,
				'calenderConnect' =>$user->CalenderConnect,
				'contactAdded' =>$user->ContactAdded,
				'firstMessageSent' =>$user->FirstMessageSent,
				'url' => 'dashboard'
				);
				$this->session->set_userdata($data);
				return array("status"=>1,"data"=>$data,"message"=>'success');
			}
			else
			{
				if($user && $user->Status  == 0)
				{
					$this->session->set_flashdata('error','Your account is locked by Admin');
					return array("status"=>0,"data"=>'',"message"=>'Your account is locked by Admin.');	
				}
				else
				{
						$this->session->set_flashdata('error','Incorrect Username and Password');
						return array("status"=>0,"data"=>'',"message"=>'Incorrect Username and Password');	
				}
			}
	}
	public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }
	public function loggedin() {
        return (bool) $this->session->userdata('loggedin');
    }

    	
}
?>