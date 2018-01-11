<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadSources extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url=base_url();
		$this->load->model('leadsource_model');
	   
	}
	public function store()
    {
		$_POST = json_decode(file_get_contents('php://input'),true);
    	$insert = $this->input->post();
		$response = $this->lead_model->saveLead($insert);
		echo json_encode($response);
	}
	public function getLeadSource()
	{
		$response = $this->leadsource_model->getLeadSource();
		echo json_encode($response);	
	}
	
	
}
