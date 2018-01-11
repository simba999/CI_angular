<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Task_model extends MY_Model {
	
	public $_table_name = 'tasks';
	public $_template_table_name = 'task_templates';
    protected $_order_by;
    public $_primary_key;
	public $collection;
    public $rules = array(
    );
	
	function saveTask($data)
	{
		$this->db->insert($this->_table_name,$data);
		$taskId = $this->db->insert_id();
		if($taskId)
		{
			return array("status"=>1,"data"=>$taskId,"message"=>'Congratulations your task is created successfully!');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getDailyTask()
	{
		$userId = $this->session->userdata('id');
		$this->db->select('t.Id,t.Title as taskTitle,t.Description as taskDescription,t.DueDate,t.Status as taskStatus,CONCAT(l.FirstName," ",l.LastName)as leadUserName,CONCAT(u.FirstName," ",u.LastName)as assignUser,u1.ProfileImage as leadUserImage,t.LeadId as leadId,NOW() as currentTime');
		$this->db->from('tasks as t');   
		$this->db->join('leads as l','l.Id = t.LeadId');	
		$this->db->join('users as u','u.ReferanceId = t.AssignTo');	
		$this->db->join('users as u1','u1.ReferanceId = l.CreatedBy');
		$this->db->where(array('t.IsDeleted'=>'0','t.DueDate'=>date('Y-m-d'),'t.Status'=>'Open'));
		$where = '(t.CreatedBy='.$userId.' or t.AssignTo = '.$userId.')';
		$this->db->where($where);
		$query = $this->db->get();
		$dailyTask = array();
		foreach ($query->result() as $row)
		{
			array_push($dailyTask, $row);
		}
		return $dailyTask;
	}
	public function getAllTasks()
	{	
		$this->db->select('t.Id,t.Title as taskTitle,t.Description as taskDescription,t.DueDate,t.Status as taskStatus,CONCAT(l.FirstName," ",l.LastName)as leadUserName,l.Title as leadTitle ,CONCAT(u.FirstName," ",u.LastName)as assignUser,u1.ProfileImage as leadUserImage,t.LeadId as leadId,tt.Id as templateId,tt.Title as templateTitle');
		$this->db->from('tasks as t');   
		$this->db->join('leads as l','l.Id = t.LeadId','left');	
		$this->db->join('task_templates as tt','tt.Id = t.TemplateId','left');	
		$this->db->join('users as u','u.ReferanceId = t.AssignTo','left');	
		$this->db->join('users as u1','u1.ReferanceId = l.CreatedBy','left');
		$this->db->where(array('t.IsDeleted'=>'0'));
		$query = $this->db->get();
		$allTask = array();
		foreach ($query->result() as $row)
		{
			array_push($allTask, $row);
		}
		if(!empty($allTask))
		{
			return array("status"=>1,"data"=>$allTask,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found','Query'=>$this->db->last_query());
		}
		
	}
	
	public function getTaskById($taskId)
	{
			$this->db->select('t.Id,t.LeadId,t.Title as taskTitle,t.Description as taskDescription,t.DueDate,t.Status as taskStatus,CONCAT(l.FirstName," ",l.LastName)as leadUserName,CONCAT(u.FirstName," ",u.LastName)as assignUser,u1.ProfileImage as leadUserImage,l.Title as leadTitle,CONCAT(l.FirstName," ",l.LastName)as leadUserName,u.Id as assignUserId');
			$this->db->from('tasks as t');   
			$this->db->join('leads as l','l.Id = t.LeadId');	
			$this->db->join('users as u','u.ReferanceId = t.AssignTo');	
			$this->db->join('users as u1','u1.ReferanceId = l.CreatedBy');	
			$this->db->where('t.Id',$taskId);	
			
			$query = $this->db->get();
			$row = $query->row();
			return $row;
			
	}
	public function setReminderForTask($data,$editTaskId)
	{
		$this->db->where('Id', $editTaskId);
		$this->db->update('tasks', $data); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getOverDueTaskList()
	{
		$userId = $this->session->userdata('id');
		$this->db->select('t.Id,t.Title as taskTitle,t.Description as taskDescription,t.DueDate,t.Status as taskStatus,CONCAT(l.FirstName," ",l.LastName)as leadUserName,CONCAT(u.FirstName," ",u.LastName)as assignUser,u1.ProfileImage as leadUserImage,t.LeadId as leadId');
		$this->db->from('tasks as t');   
		$this->db->join('leads as l','l.Id = t.LeadId');	
		$this->db->join('users as u','u.ReferanceId = t.AssignTo');	
		$this->db->join('users as u1','u1.ReferanceId = l.CreatedBy');
		$this->db->where(array('t.DueDate < '=>date('Y-m-d'),'t.IsDeleted'=>0));
		$where = '(t.CreatedBy='.$userId.' or t.AssignTo = '.$userId.')';
		$this->db->where($where);
		$query = $this->db->get();
		$overDueTask = array();
		foreach ($query->result() as $row)
		{
			array_push($overDueTask, $row);
		}
		return $overDueTask;
	}
	public function updateTask($data,$taskId)
	{
		$this->db->where('Id', $taskId);
		$this->db->update('tasks', $data); 
		if($this->db->affected_rows() > 0)
		{
			return array("status"=>1,"data"=>$this->db->affected_rows(),"message"=>'Congratulations your task is created successfully!');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');
		}
	}
	public function getCalanderTasks(){
			$this->db->select('Id as taskId,Title as title,	DueDate as start');
			$this->db->from('tasks');
			$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'IsDeleted' => 0,'DueDate >=' =>  date('Y-m-d')));
			$query = $this->db->get();
			$dailyTask = array();
			$dueTask = array();
			$calanderTasks = array();
			foreach ($query->result() as $row)
			{
				array_push($dailyTask, $row);
			}
			
			$this->db->select('Id as taskId,Title as title,	DueDate as start');
			$this->db->from('tasks');
			$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'IsDeleted' => 0,'DueDate <' =>  date('Y-m-d')));
			$query = $this->db->get();
			foreach ($query->result() as $row)
			{
				array_push($dueTask, $row);
			}
			$calanderTasks['dailyTask']= $dailyTask;
			$calanderTasks['dueTask']=  $dueTask;
			//echo $this->db->last_query();
			return $calanderTasks;
	}
	public function getCalanderOverDueTasks(){
			$this->db->select('Id as taskId,Title as title,	DueDate as start');
			$this->db->from('tasks');
			$this->db->where(array('CreatedBy'=>$this->session->userdata('id'),'IsDeleted' => 0,'DueDate <' =>  date('Y-m-d')));
			$query = $this->db->get();
			$calanderTasks = array();
			foreach ($query->result() as $row)
			{
				array_push($calanderTasks, $row);
			}
			return $calanderTasks;
	}
	public function getFilterdTaskData($filterValue)
	{
	
		$taskFilter = unserialize(DATABASEFILTER);
		$filter = $taskFilter[$filterValue];
		$filterCondition = array();
		if(!empty($filter))
		{
			$filterCondition = explode('@',$filter);
		}
		$this->db->select('t.Id,t.Title as taskTitle,t.Description as taskDescription,t.DueDate,t.Status as taskStatus,CONCAT(l.FirstName," ",l.LastName)as leadUserName,CONCAT(u.FirstName," ",u.LastName)as assignUser,u1.ProfileImage as leadUserImage,t.LeadId as leadId');
		$this->db->from('tasks as t');   
		$this->db->join('leads as l','l.Id = t.LeadId');	
		$this->db->join('users as u','u.ReferanceId = t.AssignTo');	
		$this->db->join('users as u1','u1.ReferanceId = l.CreatedBy');
		$this->db->where(array('t.IsDeleted'=>'0','t.Status'=>'Open'));
		//$this->db->or_where('t.CreatedBy',$this->session->userdata('id'));
		//$this->db->or_where('t.AssignTo',$this->session->userdata('id'));
		if(!empty($filterCondition))
		{
			$this->db->where($filterCondition[0],$filterCondition[1]);
		}
		$query = $this->db->get();
		$dailyTask = array();
		foreach ($query->result() as $row)
		{
			array_push($dailyTask, $row);
		}
		if(!empty($dailyTask))
		{
			return array("status"=>1,"data"=>$dailyTask,"message"=>'success','queery'=>$this->db->last_query());
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found','queery'=>$this->db->last_query());
		}
	}
	public function createTemplate($data)
	{
		$this->db->insert($this->_template_table_name,$data);
		$templateId = $this->db->insert_id();
		if($templateId)
		{
			return $templateId;
		}
		else
		{
			return false;
		}
	}
	public function getAllUnassignedTemplate()
	{
		$this->db->select('Id,Title as templateTitle');
		$this->db->from($this->_template_table_name);	
		$this->db->where(array('IsDeleted'=>1,'LeadId'=>0));
		$query = $this->db->get();
		$templateDropDown = array();
		foreach ($query->result() as $row)
		{
				array_push($templateDropDown,$row);
		}
		if(!empty($templateDropDown))
		{
			return array("status"=>1,"data"=>$templateDropDown,"message"=>'success');
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry no data found');
		}
	}
}
?>