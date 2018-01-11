<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadInteractionTypes extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url = base_url();
		$this->load->model('leadinteractiontype_model');
	   
	}
	public function getAllLeadInteractionTypes()
	{
		$response = $this->leadinteractiontype_model->getLeadInteractionType();
		echo json_encode($response);
		
	}
	
	
}
