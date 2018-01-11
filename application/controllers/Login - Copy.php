<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends  CI_Controller
{
	public function __construct()
  	{
	   	parent::__construct();
		$this->load->library('session');
	   	$base_url=base_url();
		$this->load->model('login_model');
	   
	}
	public function index()
	{
		/* $dashboard = $this->session->userdata('url');
		$this->login_model->loggedin() == FALSE || redirect($dashboard);
		$rules = $this->login_model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
			$response =  $this->login_model->login();
			if ($response['status'] == 1) {
				//redirect(base_url($dashboard));
				redirect($dashboard);
            } else {
				//redirect(base_url('login'), 'refresh');
				 redirect('login', 'refresh');
            }
        }
		$this->load->view('login'); */
		if(isset($_GET['ac_token']) &&  !empty($_GET['ac_token']))
		{
			

				/*$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://printbuilder.agentcloud.com/api/login",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "email=umeshp%40itpathsolutions.co.in&password=ips12345",
				  CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: application/x-www-form-urlencoded",
					"postman-token: 35cb54b2-8b45-7c23-cfcf-7ae0b6da319d"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
				  echo $response;
				}
					*/		
				//$email = 'umeshp@itpathsolutions.co.in';
				//$password = 'ips12345';
				$requestUrl = "https://printbuilder.agentcloud.com/api/me";
				$token = $_GET['ac_token'];
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => $requestUrl ,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			    CURLOPT_CUSTOMREQUEST => "GET",
			    CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"postman-token: 24ac5a74-74ee-720c-c6d7-bcc962d78a1b",
				"token: $token"
			  ),
			 ));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
				//echo $response;
				
			  $responseData =  json_decode($response);
			  print_r($responseData->data);
			  echo $responseData->data->firstName;
			  exit;
			  $token = "";
			  if($responseData->success == 1 && $responseData->auth == 1)
			  {
					$token = $responseData->token;	
			  }
			} 
			//$user =  $this->db->get_where('users', array('UserName' =>'denis007','Password'=>$this->login_model->hash('denis007')))->row();
			if(!empty($responseData->data))
			{
				
				$data = array(
				'betaKey' => $responseData->data->betaKey,
				'mlsID' => $responseData->data->mlsID,
				'firstName' => $responseData->data->firstName,
				'lastName' => $responseData->data->lastName,
				'email' =>  $responseData->data->email,
				'cellPhone' =>  $responseData->data->cellPhone,
				'breNumber' =>  $responseData->data->breNumber,
				'businessAddress' =>  $responseData->data->businessAddress,
				'businessAddress2' =>  $responseData->data->businessAddress2,
				'city' =>  $responseData->data->city,
				'state' =>  $responseData->data->state,
				'zipcode' =>  $responseData->data->zipcode,
				'website' =>  $responseData->data->website,
				'facebook' =>  $responseData->data->facebook,
				'linkedin' =>  $responseData->data->linkedin,
				'twitter' =>  $responseData->data->twitter,
				'instagram' =>  $responseData->data->instagram,
				'pinterest' =>  $responseData->data->pinterest,
				'id' => $responseData->data->wp_user_id,
				'iat' => $responseData->data->iat,
				'exp' => $responseData->data->exp,
				'loggedin' => TRUE,
				//'roleId' => $user->RoleId,
				//'status' => $user->Status,
				'user_fullname' => $responseData->data->firstName." ".$responseData->data->lastName
				'user_profile' => $responseData->data->photo,
				//'created_by' => $user->CreatedBy,
				/* 'emailConnect' =>$user->EmailConnect,
				'calenderConnect' =>$user->CalenderConnect,
				'contactAdded' =>$user->ContactAdded,
				'firstMessageSent' =>$user->FirstMessageSent, */
				'url' => 'dashboard'
				);
				$this->session->set_userdata($data);
				redirect(base_url('dashboard'), 'refresh');
				//return array("status"=>1,"data"=>$data,"message"=>'success');
			}
		}
		/* else if(!$this->session->userdata('token'))
		{
			
		} */
		else
		{
			//$redirectUrl = 'http://agentcloud.com/?login_modal=show&redirect='.base_url('dashboard');
			$redirectUrl = 'https://printbuilder.agentcloud.com/dashboard';
			redirect($redirectUrl);
			//redirect(base_url('login'), 'refresh');
		}
	}
	
}
?>