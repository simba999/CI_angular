<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadStatus extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url=base_url();
		$this->load->model('leadstatus_model');
	   
	}
	public function store()
    {
		$_POST = json_decode(file_get_contents('php://input'),true);
    	$insert = $this->input->post();
		$response = $this->leadstatus_model->saveLead($insert);
		echo json_encode($response);
	}
	public function getLeadStatus()
	{
		$response = $this->leadstatus_model->getLeadStatus();
		echo json_encode($response);	
	}
	
	
}
