<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url=base_url();
		$this->load->library("pagination");
		$this->load->model('Listing_model');
	}

	public function index()
	{
		if(!$this->session->userdata('loggedin')){
			redirect(base_url('login'), 'refresh');
		}
		
		$curIndex = 1;

		if ($this->session->userdata('linkIndex')) {
			$curIndex = $this->session->userdata('linkIndex');
		}

		$this->load->view('components/htmlheader');
		$this->load->view('components/header');
		$this->load->view('components/sidebar');
		$data['curIndex'] = $curIndex;
		$this->load->view('listing/index', $data);
	}

	public function tilesview(){
		if(!$this->session->userdata('loggedin')){
			redirect(base_url('login'), 'refresh');
		}
		$this->load->view('components/htmlheader');
		$this->load->view('components/header');
		$this->load->view('components/sidebar');
		$this->load->view('listing/tilesview');
	}

	public function propertydetail(){
		if(!$this->session->userdata('loggedin')){
			redirect(base_url('login'), 'refresh');
		}
		$propertyId = $this->uri->segment(3);
		$data['listdetail'] = $this->Listing_model->getPropertyDetailById($propertyId);
		$this->load->view('components/htmlheader');
		$this->load->view('components/header');
		$this->load->view('components/sidebar');
		$this->load->view('listing/detail',$data);
	}

	public function getAllListing(){
		if(isset($_POST['filter']) && !empty($_POST['filter'])){
			parse_str($_POST['filter'],$_POST['filter']);
		}
		if(isset($_POST['search']) && !empty($_POST['search'])){
			parse_str($_POST['search'],$_POST['search']);
		}
			
		  $config = array();
		  $config["base_url"] = "#";
		  $config["total_rows"] = $this->Listing_model->getListingCount($_POST);
		  $config["per_page"] = 10;
		  $config["uri_segment"] = 3;
		  $config["use_page_numbers"] = TRUE;
		  $config["full_tag_open"] = '<ul class="pagination contact-list">';
		  $config["full_tag_close"] = '</ul>';
		  $config["first_tag_open"] = '<li class="page-item">';
		  $config["first_tag_close"] = '</li>';
		  $config["last_tag_open"] = '<li class="page-item">';
		  $config["last_tag_close"] = '</li>';
		  $config['next_link'] = '&gt;';
		  $config["next_tag_open"] = '<li class="page-item">';
		  $config["next_tag_close"] = '</li>';
		  $config["prev_link"] = "&lt;";
		  $config["prev_tag_open"] = "<li class='page-item'>";
		  $config["prev_tag_close"] = "</li>";
		  $config["cur_tag_open"] = "<li class='active'><a href='#' class='page-link'>";
		  $config["cur_tag_close"] = "</a></li>";
		  $config["num_tag_open"] = "<li class='page-item'>";
		  $config["num_tag_close"] = "</li>";
		  $config["num_links"] = 1;
		  $this->pagination->initialize($config);
		  $page = $this->uri->segment(3);
		  $start = ($page - 1) * $config["per_page"];

		  $this->session->set_flashdata('linkIndex', $page);

		  $output = array(
		   'pagination_link'  => $this->pagination->create_links(),
		   'listings'   => $this->Listing_model->getAllListing($config["per_page"],$start,$_POST),
		   'listing_count'   => $this->Listing_model->getListingCount($_POST),
		  );
		  echo json_encode($output);
	}

	
}


