<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	
	public function __construct()
  	{
	   	parent::__construct();
	   	$base_url=base_url();
		$this->load->model('user_model');
	   
	}
	public function store()
    {
		 $post = $this->input->post();
		 $insetData = array(
			'RoleId' => 5,
			'UserName' => $post['username'],
			'Email' => $post['userEmail'],
			'FirstName' => $post['userFirstName'],
			'LastName'=>$post['userLastName'],
			'Password'=>$this->hash($post['userPassword']),
			'CreatedBy' => $this->session->userdata('id'),
			'UpdatedBy' => $this->session->userdata('id'),
		);
		if (!is_dir(UPLOAD_DIR."/".IMAGE ."/".USER_IMAGE)) {
			mkdir(UPLOAD_DIR."/".IMAGE ."/".USER_IMAGE,0777,TRUE);
		}
		if (!is_dir(UPLOAD_DIR."/".IMAGE ."/".USER_IMAGE_THUMB_PATH)) {
			mkdir(UPLOAD_DIR."/".IMAGE ."/".USER_IMAGE_THUMB_PATH,0777,TRUE);
		} 
		 $config['upload_path'] = UPLOAD_DIR."/".IMAGE ."/".USER_IMAGE."/";
		 $config['allowed_types'] = 'gif|jpg|png';
		 $config['max_size'] = 1024 * 8;
		 $config['encrypt_name'] = TRUE;
		 $config['overwrite'] = TRUE;
		 $imageUploadError = 1;
		 $this->load->library('upload', $config);
		 
		if(!empty($_FILES['userImage']))
		{
			if (!$this->upload->do_upload('userImage'))
			{
					$imageUploadError  = 2;
			}
			else
			{		$data = $this->upload->data();
					$config1 = array(
								'source_image' => $data['full_path'],
								'new_image' => UPLOAD_DIR."/".IMAGE ."/".USER_IMAGE_THUMB_PATH."/",
								'maintain_ratio' => false,
								'width' => USER_THUMB_SIZE,
								'height' =>USER_THUMB_SIZE
							);
							$this->load->library('image_lib', $config1); //load library
							$this->image_lib->resize(); //generating thumb
					$insetData['ProfileImage'] = $data['file_name'];
			}
		}
		if($imageUploadError == 1)
		{
			$response = $this->user_model->saveUser($insetData);
			echo json_encode($response);
		}
		else
		{
			echo json_encode(array('status'=>'0','data'=>false,'message'=>$this->upload->display_errors()." Please upload only image files"));
		}
		
		 
	}
	public function getAssignUsers()
	{
		$response = $this->user_model->getAssignUsers();
		echo json_encode($response);	
	}
	public function getAssignUsersForEmailMsg()
	{
		$response = $this->user_model->getAssignUsersForEmailMsg();
		echo json_encode($response);	
		die;
	}
	public function getHotLeads()
	{
		$response = $this->lead_model->getHotLeads();
		echo json_encode($response);	
	}
	
}
