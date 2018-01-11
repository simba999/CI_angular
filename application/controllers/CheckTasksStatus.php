<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 0);

//defined('BASEPATH') OR exit('No direct script access allowed');
class CheckTasksStatus extends  CI_Controller
{
	public function __construct()
  	{
	   	parent::__construct();
		$this->load->model('checkTasksStatus_model');
	}
	public function index()
	{
		$status = $this->checkTasksStatus_model->checkAndUpdateTasksStatus();
	}
	
}
?>