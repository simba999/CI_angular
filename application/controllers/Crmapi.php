<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 0);
class Crmapi extends  CI_Controller
{
	public function __construct()
  	{
		parent::__construct();
		$this->load->model('api_model');
	}
	public function index()
	{
		
		$searchKeyWord = $this->input->post("search_keyword");
		$userId = $this->input->post("wp_user_id");
		if(empty($searchKeyWord) || empty($userId))
		{
			echo json_encode(array('status' => '0', 'data' => false, 'message'=>'Please pass both required parameters searchKeyWord and User Id'));
			exit;
		}
		else
		{
			$leadDetails = $this->api_model->getLeadDataBySearch($searchKeyWord,$userId);
			$propertyDetails = $this->api_model->getAllProperty($searchKeyWord,$userId);
			$eventDetails = $this->api_model->getAllEvents($searchKeyWord,$userId);
			$data = array();
			$data['leadDetails'] = $leadDetails;
			$data['propertyDetails'] = $propertyDetails;
			$data['eventDetails'] = $eventDetails;
			echo json_encode(array('status' => '1','data' =>$data,'message'=>'Your search result inside data'));
			exit;
		}
		
	}
	
}
?>