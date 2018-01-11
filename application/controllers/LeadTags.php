<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadTags extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $base_url = base_url();
        $this->load->model('leadtag_model');
        
    }

    public function store() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_rules('leadId', 'Lead Id', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => 0, 'message' => validation_errors(), 'title' => 'Validation Errors'));
        } else {
            $leadId = $this->input->post('leadId');
            $tags = $this->input->post('selectedTags');
            foreach ($tags as $tag) {
                $data = array();
                $data['LeadId'] = $leadId;
                $data['CreatedBy'] = $this->session->userdata('id');
                $data['UpdatedBy'] = $this->session->userdata('id');
				$searchString = ',';
				if(strpos($tag, $searchString) !== false) {
					$vals = explode($searchString, $tag);
					$tag = $vals;
					foreach($tag as $t)
					{
						$data['TagTitle'] = strtolower(trim($t));
						$tagExists = $this->leadtag_model->checkTagExists($data);
						if ($tagExists['status'] == 1) 
						{
							$response = $this->leadtag_model->saveTags($data);
						} else 
						{
							$response = $tagExists;
						}
					}
				}
				else {
					$data['TagTitle'] = strtolower(trim($tag));
					$tagExists = $this->leadtag_model->checkTagExists($data);
					if ($tagExists['status'] == 1) {
						$response = $this->leadtag_model->saveTags($data);
					} else {
						$response = $tagExists;
					}
				}
            }
            echo json_encode($response);
        }
    }

    public function getAllTags() {
		 $leadId = $this->input->get('currentLeadId');
         $response = $this->leadtag_model->getAllTags($leadId);
         echo json_encode($response);
    }
	public function getTagByLeadId()
	{
		$leadId = $this->input->get('currentLeadId');
        $response = $this->leadtag_model->getTagByLeadId($leadId);
        echo json_encode($response);
	}
	public function deleteTag()
	{
		$tagId = $this->input->get('tagId');
        $response = $this->leadtag_model->deleteTag($tagId);
        echo json_encode($response);
	}
	
}
