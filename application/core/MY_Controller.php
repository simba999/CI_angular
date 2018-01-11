<?php
/**
 * Description of MY_Controller
 *
 * @author IPS
 */
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$loggedin = $this->session->userdata('loggedin');
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
					if(!empty($user))
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
					'roleId' => $roleId,
					//'status' => $user->Status,
					'user_fullname' => $responseData->data->firstName." ".$responseData->data->lastName,
					'user_profile' => $responseData->data->photo,
					//'created_by' => $user->CreatedBy,
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
		if($loggedin){
				//redirect(base_url('dashboard'), 'refresh');
		}
		else
		{
			//$redirectUrl = 'https://printbuilder.agentcloud.com/dashboard';
			redirect(API_REDIRECT_URL);
		}
		
	}
	public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }
	 
}
