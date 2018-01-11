<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Circle extends MY_Controller {

    public $_table_circles = 'circles';
    public $_table_LeadCircle = 'lead_circle';

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $this->load->view('circle/index');
    }

    public function getCircles() {
       $param = array(
           "circle.*" , 
           "( SELECT COUNT(Id) FROM {$this->_table_LeadCircle} WHERE CircleId = circle.Id) AS totalLead "
           );
        $condition = array(
            'circle.Deleted' => 0,
            'circle.Status' => 1,
			'circle.CreatedBy'=>$this->session->userdata('id'),
        );
        $circles = $this->crud->select($this->_table_circles.' AS circle', $condition,$param);
        
        echo json_encode($circles);
    }
	public function searchCircle()
	{
		 $searchText = strtolower($this->input->get('searchText'));
		$param = array(
           "circle.*" , 
           "( SELECT COUNT(Id) FROM {$this->_table_LeadCircle} WHERE CircleId = circle.Id) AS totalLead "
           );
        $condition = array(
			'circle.CreatedBy'=>$this->session->userdata('id'),
            'circle.Deleted' => 0,
            'circle.Status' => 1,
            'lower(circle.name) LIKE ' => '%'.$searchText.'%',
        );
        $circles = $this->crud->select($this->_table_circles.' AS circle', $condition,$param);
        echo json_encode($circles);
	}
    public function createCircle() {
        $data = json_decode(file_get_contents('php://input'), true);

        $addCircleData = array(
            "Name" => $data['Name'],
            "Goal" => $data['goal'],
            "Color" => $data['color'],
            "ReminderDay" => $data['reminder'],
            "UpdatedBy" => $this->session->userdata('id'),
            "CreatedBy" => $this->session->userdata('id'),
            "CreatedAt" => date('Y-m-d H:i:s'),
            "UpdatedAt" => date('Y-m-d H:i:s'),
        );

        if (!empty($data['circleId'])) {
            $circleId = $data['circleId'];
            $condition = array(
                'Id' => $circleId
            );
            $circleId = $this->crud->update($this->_table_circles, $addCircleData,$condition);
        } else {
            $circleId = $this->crud->insert($this->_table_circles, $addCircleData);
        }

        if ($circleId) {
            $response = array("status" => 1, "circle" => $circleId, "message" => 'success');
        } else {
            $response = array("status" => 0, "message" => 'something Wrong');
        }
        echo json_encode($response);
    }

    public function getSingleCircle() {
        $circleId = $this->input->get('circleId');
        $condition = array(
            'Deleted' => 0,
            'Status' => 1,
            'Id' => $circleId,
        );
        $circles = $this->crud->selectOne($this->_table_circles, $condition);

        echo json_encode($circles);
    }

    public function deleteCircle() {
        $circleId = $this->input->get('circleId');
        $condition = array(
            'Id' => $circleId,
        );
        $data = array(
            'Deleted' => 1
        );
        $circles = $this->crud->update($this->_table_circles, $data, $condition);

        if ($circles) {
            $response = array("status" => 1, "circle" => $circleId, "message" => 'success');
        } else {
            $response = array("status" => 0, "message" => 'something Wrong');
        }
        echo json_encode($response);
    }

}
