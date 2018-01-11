<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 0);

//defined('BASEPATH') OR exit('No direct script access allowed');
class GetLeadCountForLeadCreator extends  CI_Controller
{
	public function __construct()
  	{
	   	parent::__construct();
		$this->load->model('GetLeadCountForLeadCreator_model');
	}
	public function index()
	{
		$leadCretor = $this->input->post("wp_user_id");
		if(empty($leadCretor))
		{
			echo json_encode(array('status' => '0', 'data' => false, 'message'=>'Please pass wp_user_id as parameters'));
			exit;
		}
		else
		{
			$numberOfLeads = $this->GetLeadCountForLeadCreator_model->getNumberOFLeadCountForLeadCreator($leadCretor);
			echo json_encode($numberOfLeads);
			exit;
		}
	}
	
}
?>