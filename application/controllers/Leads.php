<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $base_url = base_url();
        $this->load->model('lead_model');
        $this->load->model('user_model');
        $this->load->model('leadtag_model');
    }
    public function getLeadUser(){
        $response = $this->lead_model->getLeadUser();
        echo json_encode($response);
    }
    public function store() {

      
        $insert = $this->input->post();
		$this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        //$this->form_validation->set_rules('phoneNumber', 'Phone Number', 'required');
        //$this->form_validation->set_rules('birthdate', 'Birthdate', 'required');
        //$this->form_validation->set_rules('aniversaryDate', 'Aniversary Date', 'required');
        //$this->form_validation->set_rules('leadTitle', 'Lead Title', 'required');
        //$this->form_validation->set_rules('companyName', 'Company Name', 'required');
        //$this->form_validation->set_rules('leadSource', 'Lead Source', 'required');
        //$this->form_validation->set_rules('leadStatus', 'Lead Status', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("status" => 0, 'message' => validation_errors(), 'title' => 'Validation Errors'));
        } else {
			$leadData = array(
                'Title' => $insert['leadTitle'],
                'ClientId' => $this->session->userdata('id'),
                'CompanyName' => $insert['companyName'],
                'FirstName'=>$insert['firstName'],
                'LastName'=>$insert['lastName'],
                'Email' => $insert['email'],
                'PhoneNo' => $insert['phoneNumber'],
                'BirthDate' => DateTime::createFromFormat("m-d-Y" ,$insert['birthdate'])->format('Y-m-d'),
                'AniversaryDate' => DateTime::createFromFormat("m-d-Y",$insert['aniversaryDate'])->format('Y-m-d'),
                'LeadSourceId' => $insert['leadSource'],
                'LeadStatusId' => $insert['leadStatus'],
                'WebSite' => $insert['leadWebSite'],
                'AddressLine1' => $insert['addressLine1'],
                'AddressLine2' => $insert['addressLine2'],
                'Zipcode' => $insert['zipcode'],
                'SocialProfile' => $insert['socialProfile'],
                'City' => $insert['leadCity'],
                'State' => $insert['leadState'],
                'CreatedBy' => $this->session->userdata('id'),
                'UpdatedBy' => $this->session->userdata('id'),
                'AssignedUserId' => $this->session->userdata('id'),
            );
            if (isset($insert['Id']) && !empty($insert['Id'])) {
                $leadData['Id'] = $insert['Id'];
            }
            if (!is_dir(UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE)) {
                mkdir(UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE, 0777, TRUE);
            }
            if (!is_dir(UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE_THUMB_PATH)) {
                mkdir(UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE_THUMB_PATH, 0777, TRUE);
            }
            $config['upload_path'] = UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE . "/";
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;
            $config['overwrite'] = FALSE;
            $imageUploadError = 1;
            $this->load->library('upload', $config);

            if (!empty($_FILES['leadImage'])) {
                if (!$this->upload->do_upload('leadImage')) {
                    $imageUploadError = 2;
                } else {
                    $data = $this->upload->data();
                    $config1 = array(
                        'source_image' => $data['full_path'],
                        'new_image' => UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE_THUMB_PATH . "/",
                        'maintain_ratio' => false,
                        'width' => LEAD_THUMB_SIZE,
                        'height' => LEAD_THUMB_SIZE
                    );
                    $this->load->library('image_lib', $config1); //load library
                    $this->image_lib->resize(); //generating thumb
                    $leadData['LeadImage'] = $data['file_name'];
                }
            } else {
                if (isset($insert['Id']) && !empty($insert['Id'])) {
                    $oldImage = $this->lead_model->getImageNameByLeadId($insert['Id']);
                    $leadData['LeadImage'] = $oldImage;
                }
            }


            if ($imageUploadError == 1) {
                $response = $this->lead_model->saveLead($leadData);
				if(!empty(trim($insert['tagsList'])))
				{
					$tagArray = explode(',', trim($insert['tagsList']));
					foreach ($tagArray as $tag) {
						$data = array();
						$data['LeadId'] = $response['data'];
						$data['CreatedBy'] = $this->session->userdata('id');
						$data['UpdatedBy'] = $this->session->userdata('id');
						$data['TagTitle'] = strtolower(trim($tag));
						$tagExists = $this->leadtag_model->checkTagExists($data);
						if ($tagExists['status'] == 1) {
							$tagresponse = $this->leadtag_model->saveTags($data);
						} else {
							$tagresponse = $tagExists;
						}
					}
				}
                echo json_encode($response);
            } else {
                echo json_encode(array('status' => '0', 'data' => false, 'message' => $this->upload->display_errors() . " Please upload only image files"));
            }
        }
    }

    public function getRecenetLeads() {
        $response = $this->lead_model->getRecenetLeads();
        echo json_encode($response);
    }

    public function getHotLeads() {
        $response = $this->lead_model->getHotLeads();
        echo json_encode($response);
    }

    public function updateLeadStatus() {
        $leadId = $this->input->get('leadId');
        $data = array();
        $data['LeadStatusId'] = 1;
        $response = $this->lead_model->updateLead($data, $leadId);
        echo json_encode($response);
    }

    public function destroy() {
        $leadId = $this->input->get('leadId');
        $data = array();
        $data['IsDeleted'] = 0;
        $response = $this->lead_model->updateLead($data, $leadId);
        echo json_encode($response);
    }

    public function viewDetails($leadId) {
        $leadResponse = $this->lead_model->getLeadDetails($leadId);
		if ($leadResponse['status'] == 1) {
            $leadData['leadDetails'] = $leadResponse['data'];
			$leadData['teamMember'] = $this->user_model->getTeamMember();
			//$leadData['representedProperties'] = $this->lead_model->getRepresentedProperties();
			//$leadData['savedProperties'] = $this->lead_model->getSavedProperties();
			$this->load->view('components/htmlheader');
			$this->load->view('components/header');
			$this->load->view('components/sidebar');
			$this->load->view('leads/viewDetail', $leadData);
        }
		else
		{
			redirect(base_url('dashboard'), 'refresh');
		}
       
    }

    public function getCurrentLeadDetails() {
        $currentLeadId = $this->input->get('currentLeadId');
        $response = $this->lead_model->getLeadDetails($currentLeadId);
        echo json_encode($response);
    }

    public function getRelatedLeadDropdown() {
        $currentLeadId = $this->input->get('currentLeadId');
        $searchContactValue = $this->input->get('searchContactValue');
        $response = $this->lead_model->getRelatedLeadDropdown($currentLeadId, $searchContactValue);
        echo json_encode($response);
    }

    public function saveRelatedContact() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $insert['LeadId'] = $this->input->post('leadId');
        $insert['RelatedLeadId'] = $this->input->post('selectLead');
        $insert['Relation'] = $this->input->post('relationTitle');
        $insert['CreatedBy'] = $this->session->userdata('id');
        $insert['UpdatedBy'] = $this->session->userdata('id');
        $response = $this->lead_model->saveRelatedContact($insert);
        echo json_encode($response);
    }

    public function getRelatedContacts() {
        $currentLeadId = $this->input->get('currentLeadId');
        $response = $this->lead_model->getRelatedContacts($currentLeadId);
        echo json_encode($response);
    }

    public function deleteRelatedContact() {
        $relationId = $this->input->get('relationId');
        $response = $this->lead_model->deleteRelatedContact($relationId);
        echo json_encode($response);
    }

    public function getRelatedContactById() {
        $relationId = $this->input->get('relationId');
        $response = $this->lead_model->getRelatedContactById($relationId);
        echo json_encode($response);
    }

    public function getEditRelatedLeadDropdown() {
        $currentLeadId = $this->input->get('currentLeadId');
        $response = $this->lead_model->getEditRelatedLeadDropdown($currentLeadId);
        echo json_encode($response);
    }

    public function updateRelatedContact() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $data['Relation'] = $this->input->post('editRelationTitle');
        $editRelationId = $this->input->post('relationId');
        $response = $this->lead_model->updateRelatedContact($data, $editRelationId);
        echo json_encode($response);
    }

    public function updateLeadData() {
        // $_POST = json_decode(file_get_contents('php://input'), true);
        $leadId = $this->input->post('currentLeadId');
		$data["LeadStatusId"] = $this->input->post('leadStatusSelection');
		$data["LeadSourceId"] = $this->input->post('leadSourceSelection');
		$data['FirstName'] = $this->input->post('firstName');
		$data['Title'] = $this->input->post('leadTitle');
		$data['PhoneNo'] = $this->input->post('phoneNumber');
		$data['CompanyName'] = $this->input->post('companyName');
		$data['AniversaryDate'] = DateTime::createFromFormat("m-d-Y" ,$this->input->post('aniversaryDate'))->format('Y-m-d');
		$data['AddressLine2'] = $this->input->post('addressLine2');
		$data['State'] = $this->input->post('leadState');
		$data['LastName'] = $this->input->post('lastName');
		$data['Email'] = $this->input->post('email');
        $data['WebSite'] = $this->input->post('leadWebSite');
		$data['BirthDate'] = DateTime::createFromFormat("m-d-Y" ,$this->input->post('birthdate'))->format('Y-m-d');
		$data['AddressLine1'] = $this->input->post('addressLine1');
		$data['City'] = $this->input->post('leadCity');
		$data['Zipcode'] = $this->input->post('zipcode');
		$data['UpdatedAt'] = date('Y-m-d');

        $config['upload_path'] = UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE . "/";
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 1024 * 8;
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = FALSE;
        $imageUploadError = 1;
        $this->load->library('upload', $config);

        if (isset($insert['Id']) && !empty($leadId)) {
            $data['Id'] = $leadId;
        }

        if (!empty($_FILES['userImage'])) {
            if (!$this->upload->do_upload('userImage')) {
                $imageUploadError = 2;
            } else {
                $tdata = $this->upload->data();
                $config1 = array(
                    'source_image' => $tdata['full_path'],
                    'new_image' => UPLOAD_DIR . "/" . IMAGE . "/" . LEAD_IMAGE_THUMB_PATH . "/",
                    'maintain_ratio' => false,
                    'width' => LEAD_THUMB_SIZE,
                    'height' => LEAD_THUMB_SIZE
                );
                $this->load->library('image_lib', $config1); //load library
                $this->image_lib->resize(); //generating thumb
                $data['LeadImage'] = $tdata['file_name'];
            }
        } else {
            if (isset($data['Id']) && !empty($data['Id'])) {
                $oldImage = $this->lead_model->getImageNameByLeadId($leadId);
                $data['LeadImage'] = $oldImage;
            }
        }


        if ($imageUploadError == 1) {
            $response = $this->lead_model->updateLeadData($data, $leadId);
           
            echo json_encode($response);
        } 
        else {
            $response = $this->lead_model->updateLeadData($data, $leadId);

            echo json_encode(array('status' => '0', 'data' => false, 'message' => $this->upload->display_errors() . " Please upload only image files"));
        }
    }

    public function saveHouseHoldContact() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $insert['LeadId'] = $this->input->post('leadId');
        $insert['HouseHoldLeadId'] = $this->input->post('houseHoldLead');
        $insert['Relation'] = $this->input->post('houseHoldRelationTitle');
        $insert['CreatedBy'] = $this->session->userdata('id');
        $insert['UpdatedBy'] = $this->session->userdata('id');
        $response = $this->lead_model->saveHouseHoldContact($insert);
        echo json_encode($response);
    }

    public function getHouseHoldContacts() {
        $currentLeadId = $this->input->get('currentLeadId');
        $response = $this->lead_model->getHouseHoldContacts($currentLeadId);
        echo json_encode($response);
    }

    public function getLeadListDropdown() {
        $response = $this->lead_model->getLeadListDropdown();
        echo json_encode($response);
    }

    public function deleteHouseHoldContact() {
        $houseHoldId = $this->input->get('houseHoldId');
        $response = $this->lead_model->deleteHouseHoldContact($houseHoldId);
        echo json_encode($response);
    }

}
