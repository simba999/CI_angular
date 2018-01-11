<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url=base_url();
		$this->load->model('login_model');
		$this->load->model('Filter_model');
		$this->load->model('Contact_model');
		$this->load->model('Message_model');
	   
	}
	public function index() {
		if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $graph_data = array();
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        //$this->load->view('components/sidebar');
        $graph_data['circles'] = $this->Filter_model->getAllCircles();
        $this->load->model('lead_model');
        $response = $this->lead_model->getLatestAnalytics();
        $created_date = array();
        $created_date_count = array();

        foreach ($response as $analyticsdata) {
            $created_date[] = $analyticsdata->created;
            $created_date_count[] = $analyticsdata->total;
        }
        $implode_created_date = implode("','", $created_date);
        $implode_created_date_count = implode(",", $created_date_count);

        $graph_data['graph_labels'] = "'" . $implode_created_date . "'";
        $graph_data['graph_data'] = $implode_created_date_count;
        $graph_data['today_tasks_completed_in_progress'] = $this->Filter_model->getAllTaskProgressByLogginId();
        $this->load->view('dashboard/index', $graph_data);
    }

    public function addContactToCircel()
	{
		$result = $this->Contact_model->addContactTocircle($_POST);
		if($result){
			$this->session->set_userdata('contactAdded', '1');
			$this->session->set_flashdata('addContactSuccessfully',true);
			redirect('dashboard/index','refresh');
		}
	}
	
	public function addFlagForFirstMessage()
	{
		$result = $this->Message_model->addFlagForFirstMessage($_POST);
		echo json_encode($result);
	}
}
