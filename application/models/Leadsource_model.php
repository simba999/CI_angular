<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leadsource_model extends MY_Model {
	
	public $_table_name;
    protected $_order_by;
    public $_primary_key;
	public $collection;
    public $rules = array(
    );
	
	function saveTask($data)
	{
		$this->collection = $this->database->tasks;
		$insertOneResult = $this->collection->insertOne(
			[
			'TaskTitle' => $data['taskTitle'],
			'TaskDescription' => $data['taskDescription'],
			'TaskLeadId' => $data['taskLeadId'],
			'TaskDueDate'=>$data['taskDueDate'],
			//'AssignTo'=>$data['assignTo'],
			'CreatedBy' => $this->session->userdata('userId'),
			'UpdatedBy' => $this->session->userdata('userId'),
			'CreatedAt' => date('Y-m-d H:i:s'),
			'UpdatedAt' => date('Y-m-d H:i:s'),
			]
		);
		if($insertOneResult->getInsertedId())
		{
			return array("status"=>1,"data"=>$insertOneResult->getInsertedId(),"message"=>'success',"id"=>$insertOneResult->getInsertedId());	
		}
		else
		{
			return array("status"=>0,"data"=>'',"message"=>'Sorry There is some error');	
		}
	}
	public function getLeadSource()
	{
		$this->db->from('lead_sources');   
		$query = $this->db->get();
		$leadSource = array();
		foreach ($query->result() as $row)
		{
		array_push($leadSource, $row);
		}
		return $leadSource;
	}

    	
}
?>