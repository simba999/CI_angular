<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadCircles extends MY_Controller {

    public $_table_LeadCircle = 'lead_circle';
    public $_table_circles = 'circles';

    public function __construct() {
        parent::__construct();
        $base_url = base_url();
        $this->load->model('leadcircle_model');
    }

    public function store() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $insert['LeadId'] = $this->input->post('leadId');
        $insert['Title'] = $this->input->post('circleTitle');
        $response = $this->leadcircle_model->saveCircle($insert);
        echo json_encode($response);
    }

    public function getLeadSource() {
        $response = $this->leadcircle_model->getLeadSource();
        echo json_encode($response);
    }

    public function addLeadCircle() {
        $postData = json_decode(file_get_contents('php://input'), true);

        $circles = $postData['leadcircle'];
        $leadId = $postData['leadId'];

        $this->crud->delete($this->_table_LeadCircle, array('LeadId' => $leadId));

        foreach ($circles as $circleKey => $circle) {
		
			if($circle)
			{
				$addData = array(
					'LeadId' => $leadId,
					'CircleId' => $circleKey,
					'CreatedBy' => 1,
					'CreatedAt' => date('Y-m-d H:i:s'),
				);
				$this->crud->insert($this->_table_LeadCircle, $addData);
			}
        }

        $response = array("status" => 1, "message" => 'successfully added');

        echo json_encode($response);
    }

    public function getCircles() {

        $leadId = $this->input->get('currentLeadId');
        $condition = array(
            'Deleted' => 0,
            'Status' => 1,
			"CreatedBy" => $this->session->userdata('id'),
        );
        $circles = $this->crud->select($this->_table_circles, $condition);
        $temp = array();

        $leadCircle = $this->getLeadCircle($leadId);
        foreach ($circles as $circle) {
            if (in_array($circle['Id'], $leadCircle)) {
                $circle['checked'] = true;
            } else {
                $circle['checked'] = false;
            }
            $temp[] = $circle;
        }
		echo json_encode($temp);
    }

    public function getLeadCircle($leadId) {

        $parameter = array('CircleId');
        $condition = array(
            'LeadId' => $leadId
        );

        $leadCircles = $this->crud->select($this->_table_LeadCircle, $condition, $parameter);
        return array_column($leadCircles, 'CircleId');
    }

}
