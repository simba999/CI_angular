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
	
		if(isset($_GET['ac_token']) &&  !empty($_GET['ac_token']))
		{
				//$requestUrl = "https://printbuilder.agentcloud.com/api/me";
				$token = $_GET['ac_token'];
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => API_URL ,
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
				  //echo "cURL Error #:" . $err;
					//$redirectUrl = 'https://printbuilder.agentcloud.com/dashboard';
					redirect(API_REDIRECT_URL);
				} 
			  else {
				
				$responseData =  json_decode($response);
			    if(!empty($responseData->data))
			    {
					$emailConnect = 0;
					$calenderConnect = 0;
					$contactAdded = 0;
					$firstMessageSent = 0;
					$roleId = 4;
					$user =  $this->db->get_where('users', array('ReferanceId' =>$responseData->data->wp_user_id))->row();
					$data = array();
					if(empty($user))
					{	
							$insertData = array(
							'BetaKey' => $responseData->data->betaKey,
							'MlsId' => $responseData->data->mlsID,
							'FirstName' => $responseData->data->firstName,
							'LastName' => $responseData->data->lastName,
							'Email' =>  $responseData->data->email,
							'UserName' =>  $responseData->data->email,
							'cellPhone' =>  $responseData->data->cellPhone,
							'BreNumber' =>  $responseData->data->breNumber,
							'BrokerLicense' =>  $responseData->data->brokerLicense,
							'UserRole' =>  $responseData->data->wp_user_role,
							'BusinessAddress' =>  $responseData->data->businessAddress,
							'businessAddress2' =>  $responseData->data->businessAddress2,
							'City' =>  $responseData->data->city,
							'State' =>  $responseData->data->state,
							'Zipcode' =>  $responseData->data->zipcode,
							'Website' =>  $responseData->data->website,
							'Facebook' =>  $responseData->data->facebook,
							'Linkedin' =>  $responseData->data->linkedin,
							'Twitter' =>  $responseData->data->twitter,
							'Instagram' =>  $responseData->data->instagram,
							'Pinterest' =>  $responseData->data->pinterest,
							'ReferanceId' => $responseData->data->wp_user_id,
							'Lat' => $responseData->data->iat,
							'Exp' => $responseData->data->exp,
							'ProfileImage' => $responseData->data->photo,
							'Token' => $token,
							'RoleId' => 4,
							'CreatedBy' =>$responseData->data->wp_user_id,
							'LastLoggedId' => date('Y-m-d H:i:s')
						);
						$this->db->insert('users',$insertData);
					}
					else
					{
						 $emailConnect = $user->EmailConnect;
						 $calenderConnect = $user->CalenderConnect;
						 $contactAdded = $user->ContactAdded;
						 $firstMessageSent = $user->FirstMessageSent;
						 $roleId = $user->RoleId;
					}
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
					'brokerLicense' => $responseData->data->brokerLicense,
					'user_role' => $responseData->data->wp_user_role,
					'loggedin' => TRUE,
					'token' => $token,
					'roleId' =>$roleId,
					//'roleId' => $user->RoleId,
					//'status' => $user->Status,
					'user_fullname' => $responseData->data->firstName." ".$responseData->data->lastName,
					'user_profile' => $responseData->data->photo,
					'emailConnect' =>$emailConnect,
					'calenderConnect' =>$calenderConnect,
					'contactAdded' =>$contactAdded,
					'firstMessageSent'=>$firstMessageSent,
					'url' => 'dashboard'
					);
					$this->session->sess_expiration = $responseData->data->exp;
					$this->session->set_userdata($data);
					redirect(base_url('dashboard'), 'refresh');
				}
			}
		}
	 
		else if($this->session->userdata('loggedin')){
			redirect(base_url('dashboard'), 'refresh');
		}
		else
		{
			//$redirectUrl = 'http://agentcloud.com/?login_modal=show&redirect='.base_url('dashboard');
			//$redirectUrl = 'https://printbuilder.agentcloud.com/dashboard';
			redirect(API_REDIRECT_URL);
		}
	}
	
}
?>