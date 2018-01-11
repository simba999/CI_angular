<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadDocuments extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $base_url = base_url();
        $this->load->model('leaddocument_model');
        
    }
    public function store() {
       
		$post = $this->input->post();
        $this->form_validation->set_rules('leadId', 'Lead Id', 'required');
       // $this->form_validation->set_rules('leadDocument', 'Document', 'required');
		if ($this->form_validation->run() == FALSE)
        {
				echo json_encode(array("status"=>0,'message'=>validation_errors(), 'title'=>'Validation Errors'));
		}
		else
		{
			$post = $this->input->post();
			$leadId = $this->input->post('leadId');
			if (!is_dir(UPLOAD_DIR."/".LEAD_DOCUMENT)) {
				mkdir(UPLOAD_DIR."/".LEAD_DOCUMENT,0777,TRUE);
			}
			$documentArray = array();
			if (!empty($_FILES["leadDocuments"]['name'])) {
					 $orgFileData = array();
					 $orgFileData = $_FILES["leadDocuments"]['name'];
					 $config['upload_path'] = UPLOAD_DIR."/".LEAD_DOCUMENT."/";
					 $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
					 $config['max_size'] = 1024 * 8;
					 $config['encrypt_name'] = TRUE;
					 $config['overwrite'] = TRUE;
					 $imageUploadError = 1;
					 $this->load->library('upload', $config);
					 $totalImage = count($_FILES["leadDocuments"]['name']);
					 $orignalFileArray = array();
					 $orignalFileArray = $_FILES;
					 for($i=0;$i < $totalImage;$i++)
					 {
						$_FILES['leadDocuments']['name'] =  $orignalFileArray['leadDocuments']['name'][$i];
						$_FILES['leadDocuments']['type'] =  $orignalFileArray['leadDocuments']['type'][$i];
						$_FILES['leadDocuments']['tmp_name'] =  $orignalFileArray['leadDocuments']['tmp_name'][$i];
						$_FILES['leadDocuments']['error'] = $orignalFileArray['leadDocuments']['error'][$i];
						$_FILES['leadDocuments']['size'] = $orignalFileArray['leadDocuments']['size'][$i];
						if (!$this->upload->do_upload('leadDocuments')) {
							echo json_encode(array('status'=>'0','data'=>false,'message'=>$this->upload->display_errors()));
						} 
						else {
							$documentInfo = $this->upload->data();
							$documentArray[] = $documentInfo['file_name'];
						} 
				 	 }
					 $imageIndex = 0;
					 foreach($documentArray as $document)
					 {
								$data = array();
								$data['LeadId'] = $leadId;
								$data['DocumentPath'] = $document;
								$data["OriginalDocumentPath"] = $orgFileData[$imageIndex];
								$data['CreatedBy'] = $this->session->userdata('id');
								$data['UpdatedBy'] = $this->session->userdata('id');
								$response = $this->leaddocument_model->saveDocuments($data);
								$imageIndex++;
					 }
					echo json_encode($response);
				
			}
			else
			{
				echo json_encode(array("status"=>0,"data"=>'',"message"=>'Please upload at least on document.'));
			}
			
        }
	}
	public function getDocuments() {
		 $leadId = $this->input->get('currentLeadId');
         $response = $this->leaddocument_model->getDocuments($leadId);
         echo json_encode($response);
    }
	public function deleteDocument()
	{
		$leadDocumentId = $this->input->get('leadDocumentId');
		$document = $this->leaddocument_model->getDocumentById($leadDocumentId);
        $response = $this->leaddocument_model->deleteDocument($leadDocumentId);
		if($response['status'] == 1)
		{
			unlink(UPLOAD_DIR."/".LEAD_DOCUMENT."/".$document['data']->DocumentPath);
		}
		echo json_encode($response);
	}
	
}
