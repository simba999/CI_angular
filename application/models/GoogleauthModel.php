<?php
	
class GoogleauthModel extends MY_Model
{
		public $_table_google_calander_list = 'google_calander_list';
		public function __construct()
		{
			parent::__construct();
		}
		
		public function get_googleCred($userId) {
			
			$query = $this->db->query("SELECT refreshToken,userId from  googlecred WHERE userId =  $userId");
			if($query->num_rows()>0){
				$record = $query->result("array");
				return $record;
			}
		}
		public function get_all_googleCred() {
			
			$query = $this->db->query("SELECT refreshToken,userId from  googlecred");
			
			if($query->num_rows()>0){
				$record = $query->result("array");
				return $record;
			}
		}
		public function checkCalanderList($data)
		{
			$this->db->select('*');
			$this->db->from('google_calander_list');   
			$this->db->where(array('UserId'=>$data['UserId'],'GCalanderId'=>$data['GCalanderId']));	
			$query = $this->db->get();
			$row = $query->row();
			if(!empty($row))
			{
				return $row;
			}
			else
			{
					return 0;
			}
		}
		public function saveCalanderList($data)
	    {
			$this->db->insert($this->_table_google_calander_list,$data);
			$listId = $this->db->insert_id();
			if($listId)
			{
				return array("status"=>1,"data"=>$listId,"message"=>'Congratulations list is added!');
			}
			else
			{
				return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
			}
		}
		public function updateCalanderList($data,$id)
		{
			$this->db->where('Id',$id);
			$this->db->update($this->_table_google_calander_list,$data); 
			if($this->db->affected_rows() > 0)
			{
				return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success',"query"=>$this->db->last_query());
			}
			else
			{
				return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error',"query"=>$this->db->last_query());
			}
		}
		
}
?>
