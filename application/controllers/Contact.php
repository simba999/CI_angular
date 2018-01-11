<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $base_url = base_url();
        $this->load->model('login_model');
        $this->load->model('lead_model');
        $this->load->model('user_model');
        $this->load->model('Filter_model');
    }

    public function index() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        //$contactResponse['teamMembers'] = $this->lead_model->getLeadDetailsContact();
        $contactResponse['teamMembersAssigned'] = $this->lead_model->getAssignedUser();
        $contactResponse['AssignDataAll'] = $this->lead_model->assignUserdataSelect(); //default assignuserid get from here.
        $contactResponse['getCircle'] = $this->lead_model->getCircleForExportCSV();
        $this->load->view('contact/index', $contactResponse);
    }

//assigned user in cintact list.: (specially for get default id of assied userid from lead table)
    public function AssignUserData() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $contactResponse['AssignDataAll'] = $this->lead_model->assignUserdataSelect();
    }

    /*  Page to Import contact by upload CSV file. */

    public function import() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $this->load->view('contact/import');
    }

    /*  Upload CSV file and store data into database (table: Lead) */

    public function readCsv() {

        $keyArray = array('Title', 'FirstName', 'LastName', 'CompanyName','PhoneNo', 'BirthDate', 'AniversaryDate', 'Email', 'Location');
        if (!file_exists('./upload/contact/')) {
            mkdir('./upload/contact/', 0777, true);
        }
        $config['upload_path'] = './upload/contact/';
        $config['allowed_types'] = 'csv';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('contactcsv')) {

            echo json_encode(array('status' => '0', 'data' => false, 'message' => $this->upload->display_errors()));
        } else {
            $data = $this->upload->data();
            $this->load->library('csvreader');
            $csvDataResult = $this->csvreader->parseFile($data['full_path']); //path to csv file
            unset($csvDataResult[0]);
            /* var_dump($csvDataResult);
              die; */
            foreach ($csvDataResult as $result) {
                $temp = array();
                for ($i = 0; $i < count($result); $i++) {
                    $temp[$keyArray[$i]] = $result[$i];
                }
                $temp['ClientId'] = $this->session->userdata('id');
                $temp['CreatedBy'] = $this->session->userdata('id');
                $temp['UpdatedBy'] = $this->session->userdata('id');
                $temp['AssignedUserId'] = $this->session->userdata('id');
                $response = $this->lead_model->saveLead($temp);
            }
            echo json_encode(array('status' => '1', 'data' => '', 'message' => ''));
        }
    }

    /*  After upload CSV file then display success msg */

    public function viewMssageCsvImport() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $this->load->view('contact/importMessage');
    }

    public function contactsMerge() {

        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $contactResponse['ContactMember'] = $this->lead_model->getContactAllfromLead(); // To get all contact from 
        $contactResponse['suggetedContact'] = $this->lead_model->getGoogleContactSuggetion();
        $this->load->view('contact/contactsMerge', $contactResponse);
    }

    public function OAuth() {
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $this->load->view('contact/OAuth.php');
    }

    public function getFiltersData() {
        $contactResponse = array();
        $contactResponse['circles'] = $this->Filter_model->getAllCircles();
        $contactResponse['statuses'] = $this->Filter_model->getAllStatus();
        $contactResponse['tags'] = $this->Filter_model->getAllTags();
        $contactResponse['AssignedUsers'] = $this->user_model->getAssignUsersForEmailMsg();

        echo json_encode($contactResponse);
        exit;
    }

    public function getContactInfo()
    {

        $postData = json_decode(file_get_contents('php://input'), true);;
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        $itemsPerPage = $this->uri->segment(3);
        $pageNo = $this->uri->segment(4);

        $contactResponse['teamMembers'] = $this->lead_model->getLeadDetailsContact($postData,$itemsPerPage, $pageNo);
        $contactResponse['getCircle'] = $this->lead_model->getCircleForExportCSV();

        foreach ($contactResponse['teamMembers']['data'] as $value) {
            if(trim($value->ProfileImage) == ''){
                //$value->ProfileImage = base_url().'assets/global/images/203.jpg';    
				$value->ProfileImage = base_url().'assets/global/images/Blank_Club_Website_Avatar_Gray.jpg'; 
            }
            else{
                $value->ProfileImage = base_url().UPLOAD_DIR."/".IMAGE."/".LEAD_IMAGE_THUMB_PATH ."/".$value->ProfileImage;    
            }
            
        }

        echo json_encode($contactResponse);exit();
    }

    public function updateAssignee()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        
        $response = $this->lead_model->updateAssignee($postData);
        

        echo json_encode($response);exit();
    }

    public function exportContacts()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'), 'refresh');
        }
        if($postData['ExportChoose'] == 'export_contact_All_show_me' ){
            $post = array();
            
            $contactResponse = $this->lead_model->getLeadDetailsContact($post); 
        }
        elseif($postData['ExportChoose'] == 'export_contact_from_search_show_me' ){
            $post = array();
            $post['circle'] = $postData['circle'];
            $post['status'] = $postData['status'];
            $post['tag'] = $postData['tag'];
            $post['user'] = $postData['user'];

            $contactResponse= $this->lead_model->getLeadDetailsContact($post);
        }
        elseif($postData['ExportChoose'] == 'export_contact_from_circle_watch_me' ){
            $post = array();
            $circle = array();
            if(isset($postData['AssignedUserId'])){
                array_push($circle, $postData['AssignedUserId']);
                $post['circle'] = $circle;
                $contactResponse= $this->lead_model->getLeadDetailsContact($post);    
            }
            
        }
        $contactResponse['FileUrl'] = '';
        if(count($contactResponse['data'])){

            $outputVal = array();


            $contactResponse = json_decode(json_encode($contactResponse),true);
            $arrayKeys = array_keys($contactResponse['data'][0]);
            array_push($outputVal, $arrayKeys);
            
            $filename = 'upload/contacts-' . time() . '.csv';
            
            header("Content-Type: text/x-csv");
            header("Content-Disposition: attachment; filename='{".$filename."}'");
            $output = fopen($filename, "w");
            fputcsv($output, $arrayKeys);
            foreach ($contactResponse['data'] as $rowdetail) {
                fputcsv($output, $rowdetail);array_push($outputVal, array_values($rowdetail));
            }

            fclose($output);
            chmod($filename, 0777); 


            $contactResponse['FileUrl'] = base_url().$filename;
        }
        
        
        echo json_encode($contactResponse);exit();
    }

    public function getInteractionTypesDropdown() {
        $response = $this->lead_model->getInteractionTypesDropdown();
        echo json_encode($response);
    }

    public function saveLeadInteraction() {
        $_POST = json_decode(file_get_contents('php://input'), true);
		$insert['LeadId'] = $this->input->post('leadId');
        $insert['Title'] = $this->input->post('interactionTitle');
		$insert['InteractionDate'] = DateTime::createFromFormat("m/d/Y", str_replace('-', '/', $this->input->post('interactionDate')))->format('Y-m-d');
        $insert['InteractionTypeId'] = $this->input->post('selectInteractionType');
        $insert['Status'] = 1;
        $insert['IsDeleted'] = 1;
        $insert['CreatedBy'] = $this->session->userdata('id');
        $insert['UpdatedBy'] = $this->session->userdata('id');
		$response = $this->lead_model->saveLeadInteraction($insert);
		echo json_encode($response);
    }
	
	
	/*public function saveEmailLeadInteraction() {
        $_POST = json_decode(file_get_contents('php://input'), true);
		$insert['LeadId'] = $this->input->post('leadId');
        $insert['Title'] = $this->input->post('interactionTitle');
		$insert['InteractionDate'] = DateTime::createFromFormat("m/d/Y", str_replace('-', '/', $this->input->post('interactionDate')))->format('Y-m-d');
        $insert['InteractionTypeId'] = $this->input->post('selectInteractionType');
        $insert['Status'] = 1;
        $insert['IsDeleted'] = 1;
        $insert['CreatedBy'] = $this->session->userdata('id');
        $insert['UpdatedBy'] = $this->session->userdata('id');
		$response = $this->lead_model->saveLeadInteraction($insert);
		echo json_encode($response);
    }*/

    public function getLeadDataByLeadId() {
        //$_POST = json_decode(file_get_contents('php://input'), true);
        $leadId = $this->input->get('leadId');
        $response = $this->lead_model->getLeadDataByLeadId($leadId);
        echo json_encode($response);
    }

    public function saveContactsMerge(){
        
        $MergeFromGoogle = $this->input->post();
        foreach ($MergeFromGoogle as $lead_id => $MergeFromGoogle1) {
            $this->lead_model->saveMergeFromGoogle($MergeFromGoogle1,$lead_id);
            foreach ($MergeFromGoogle1 as $googleContact) {
                $this->lead_model->changeStatusGoogleContact($googleContact['Id'], '1');
            }
        }
        echo json_encode(array('status'=> true));
        die;
    }

}
