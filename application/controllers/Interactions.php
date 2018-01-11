<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interactions extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url=base_url();
		$this->load->model('interaction_model');
	}
	public function store()
    {
		$_POST = json_decode(file_get_contents('php://input'),true);
		$insert['LeadId'] = $this->input->post('leadId');
    	$insert['Title'] = $this->input->post('interactionTitle');
		$insert['InteractionDate'] = DateTime::createFromFormat("m-d-Y" ,$this->input->post('interactionDate'))->format('Y-m-d');
    	$insert['InteractionTypeId'] = $this->input->post('interactionTypeId');
    	$insert['CreatedBy'] = $this->session->userdata('id');
    	$insert['UpdatedBy'] = $this->session->userdata('id');
		$response = $this->interaction_model->saveInteraction($insert);
		echo json_encode($response);
	}
	public function getAllInteractions()
	{
		$interactionTypeId = $this->input->get('interactionTypeId');
		$currentLeadId = $this->input->get('currentLeadId');
		$searchInteractionDate = $this->input->get('searchInteractionDate');
		$searchInteractionTitle = $this->input->get('searchInteractionTitle');
		$response = $this->interaction_model->getAllInteractions($interactionTypeId,$currentLeadId,$searchInteractionDate,$searchInteractionTitle);
		echo json_encode($response);	
	}
	public function searchInteractions()
	{
		$_POST = json_decode(file_get_contents('php://input'),true);
		$searchCriteria = array();
		$currentLeadId = $this->input->post('leadId');
		if(!empty($currentLeadId))
		{
			$searchCriteria['leadId'] = $currentLeadId;
		}
		$searchInteractionDate = $this->input->post('searchInteractionDate');
		if(!empty($searchInteractionDate))
		{
			$searchCriteria['searchInteractionDate'] = $searchInteractionDate;
		}
		
		if(!empty($this->input->post('searchInteractionTitle')))
		{	
			$searchInteractionTitle = $this->input->post('searchInteractionTitle');
			$searchCriteria['searchInteractionTitle'] = $searchInteractionTitle;
		}
		
		$response = $this->interaction_model->searchInteractions($searchCriteria);
		echo json_encode($response);	
	}
}
