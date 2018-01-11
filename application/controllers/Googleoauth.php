<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
define('SCOPES', implode(' ', array(
  'https://www.google.com/m8/feeds/',
  Google_Service_Gmail::GMAIL_READONLY,
  Google_Service_Gmail::GMAIL_COMPOSE,
  Google_Service_Gmail::GMAIL_LABELS,
  //Google_Service_Gmail::GMAIL_METADATA,
  Google_Service_Gmail::GMAIL_MODIFY,
  Google_Service_Gmail::GMAIL_SEND,
  Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
  Google_Service_Gmail::GMAIL_SETTINGS_SHARING
  )
));
define('CALENDERSCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR,
  Google_Service_Calendar::CALENDAR_READONLY
  )
));
define('CONTACT_SCOPES', implode(' ', array(
  'https://www.google.com/m8/feeds/'
 )
));
class Googleoauth extends MY_Controller {
  
public function __construct()
    {
      parent::__construct();
      $base_url=base_url();
      $this->load->model('lead_model');
	   $this->load->model('GoogleauthModel','googleauth');
     
  }
  public function acoountconnect()
  {
		$client = new Google_Client();
		$client->setRedirectUri(site_url(). 'googleoauth/acoountconnect');
		$client->setClientId(CLIENT_ID);
		$client->setClientSecret(CLIENT_SECRET_ID);
		$client->setScopes(SCOPES);
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');
		$userId = $this->session->userdata('id');
		$max_results = 1000;
		if (!isset($_GET['code']))
		{	
					$auth_url = $client->createAuthUrl();
					header('Location: '.filter_var($auth_url, FILTER_SANITIZE_URL));

		}
		else
		{	
			        $client->authenticate($_GET['code']);
					$accessTokenArray = array();
					$accessTokenArray = $client->getAccessToken();
					$accessToken = $accessTokenArray['access_token'];
					$refreshToken = $accessTokenArray['refresh_token'];
					$this->db->select('*');
					$this->db->from('googlecred');
					$this->db->where(array('userId'=>$userId,'type' => 1));
					$query = $this->db->get();
					if ( $query->num_rows() > 0 )
					{
						$row = $query->row_array();
						$data = array(
						'accessToken' => $accessToken,
						'refreshToken' => $refreshToken
						);
						$this->db->where(array('userId'=>$userId,'type' => 1));
						$result = $this->db->update('googlecred', $data);
					}
					else
					{
						$data = array( 
						'userId' =>  $userId, 
						'accessToken' =>  $accessToken, 
						'refreshToken' => $refreshToken,
						'type' => 1
						);
						$result = $this-> db->insert('googlecred', $data);
					}
					//Insert Contact Of Users
					/*$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results . '&oauth_token='.$accessToken;
					$xmlresponse = $this->curl_file_get_contents($url);
					if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) {
						echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
						exit();
					}
					$document = new DOMDocument();
					$document->loadXml($xmlresponse);
					$xpath = new DOMXpath($document);
					$xpath->registerNamespace('atom', 'http://www.w3.org/2005/Atom');
					$xpath->registerNamespace('gd', 'http://schemas.google.com/g/2005');
					foreach ($xpath->evaluate('/atom:feed/atom:entry') as $entry) {
						$contact = [
							'FirstName' => $xpath->evaluate('string(atom:title)', $entry),
							'Image' => $xpath->evaluate('string(atom:link[@rel="http://schemas.google.com/contacts/2008/rel#photo"]/@href)', $entry),
							'Email' => [],
							'PhoneNo' => [],
							'Location'=>[],
							'Address' => []
						];
						foreach ($xpath->evaluate('gd:email', $entry) as $email) {
							$contact['Email'][] = $email->getAttribute('address');
						}
						foreach ($xpath->evaluate('gd:phoneNumber', $entry) as $number) {
							$contact['PhoneNo'][] = trim($number->textContent);
						}
						
						foreach ($xpath->evaluate('gd:organization', $entry) as $organ) {
							$contact['Location'][] = trim($organ->textContent);
						}

						foreach ($xpath->evaluate('gd:postalAddress', $entry) as $foraddress) {
							$contact['Address'][] = trim($foraddress->textContent);
						}
						if (!empty($contact['Email']))
							$contact['Email'] = $contact['Email'][0];
						if (!empty($contact['PhoneNo']))
							$contact['PhoneNo'] = $contact['PhoneNo'][0];
						
						if (!empty($contact['Location']))
							$contact['Location'] = $contact['Location'][0];

						if (!empty($contact['Address']))
							$contact['Address'] = $contact['Address'][0];
						  if (empty($contact['Address']))
							  $contact['Address'] = '';
						else
							$contact['PhoneNo'] = '';

						$emailCheck = array();
						$emailCheck['Email'] =  $contact['Email'];
						$emailCheck['UserId'] =  $this->session->userdata('id');
						 if(is_array($contact['Location'])){
									if(empty($contact['Location'])){
										$contact['Location'] = '';
									}
								}
						$contact['UserId'] = $this->session->userdata('id');
						$googleResult = $this->lead_model->checkGoogleEmailExists($emailCheck);
						if(empty($googleResult))
						{
							$this->lead_model->saveGmailContact($contact);
						}
            
					}*/
					$userData = array();
					$userData['EmailConnect'] = 1;
					$this->db->where('ReferanceId',$userId);
					$result = $this->db->update('users', $userData);
				    $this->session->set_userdata('emailConnect', '1');
				     redirect(base_url('dashboard'), 'refresh');
		}
  }
  public function connectcalender()
  {
		$client = new Google_Client();
		$client->setRedirectUri(site_url(). 'googleoauth/connectcalender');
		$client->setClientId(CLIENT_ID);
		$client->setClientSecret(CLIENT_SECRET_ID);
		$client->setScopes(CALENDERSCOPES);
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');
		$userId = $this->session->userdata('id');
		if (!isset($_GET['code']))
		{	
					$auth_url = $client->createAuthUrl();
					header('Location: '.filter_var($auth_url, FILTER_SANITIZE_URL));
		}
		else
		{	
			        $client->authenticate($_GET['code']);
					$accessTokenArray = array();
					$accessTokenArray = $client->getAccessToken();
					$accessToken = $accessTokenArray['access_token'];
					$refreshToken = $accessTokenArray['refresh_token'];
					$this->db->select('*');
					$this->db->from('googlecred');
					$this->db->where(array('userId'=>$userId,'type' => 2));
					$query = $this->db->get();
					if ( $query->num_rows() > 0 )
					{
						$row = $query->row_array();
						$data = array(
						'accessToken' => $accessToken,
						'refreshToken' => $refreshToken
						);
						$this->db->where(array('userId'=>$userId,'type' =>2));
						$result = $this->db->update('googlecred', $data);
					}
					else
					{
						$data = array( 
						'userId' =>  $userId, 
						'accessToken' =>  $accessToken, 
						'refreshToken' => $refreshToken,
						'type' => 2
						);
						$result = $this-> db->insert('googlecred', $data);
						
						
					}
					$userData = array();
					$userData['CalenderConnect'] = 1;
					$this->db->where('ReferanceId', $userId);
					$result = $this->db->update('users', $userData);
					$service = new Google_Service_Calendar($client);
					$calendarList = $service->calendarList->listCalendarList();
					foreach ($calendarList->getItems() as $calendarListEntry) {
						$calanderData = array();
						
						$calanderData['UserId'] = $userId;
						$calanderData['GCalanderId'] = $calendarListEntry->getId();
						$calanderList =  $this->googleauth->checkCalanderList($calanderData);
						$calanderData['Name'] = $calendarListEntry->getSummary();
						if($calanderList)
						{	
							 $this->googleauth->updateCalanderList($calanderData,$calanderList->Id);
						}
						else
						{
							/* $rule = new Google_Service_Calendar_AclRule();
							$scope = new Google_Service_Calendar_AclRuleScope();
							$scope->setType("default");
							$scope->setValue("");
							$rule->setScope($scope);
							$rule->setRole("reader");
							$createdRule = $service->acl->insert($calanderData['GCalanderId'], $rule);
							echo '<pre>';
							print_r($createdRule); */
							 $this->googleauth->saveCalanderList($calanderData);		
						}
					}
				$this->session->set_userdata('calenderConnect', '1');
				redirect(base_url('dashboard'), 'refresh');
		}
  }
  public function index()
  {
		
		$client = new Google_Client();
		$client->setRedirectUri(site_url(). 'googleoauth');
		$client->setScopes(CONTACT_SCOPES);
		$client->setClientId(CLIENT_ID);
		$client->setClientSecret(CLIENT_SECRET_ID);
		$max_results = 1000;
				if (!isset($_GET['code']))
				{	
					$auth_url = $client->createAuthUrl();
					header('Location: '.filter_var($auth_url, FILTER_SANITIZE_URL));

				}
				else
				{
					$client->authenticate($_GET['code']);
					$accessTokenArray = array();
					$accessTokenArray = $client->getAccessToken();
					$accessToken = $accessTokenArray['access_token'];
					$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results . '&oauth_token='.$accessToken;
					$xmlresponse = $this->curl_file_get_contents($url);
					if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) {
						echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
						exit();
					}
					$document = new DOMDocument();
					$document->loadXml($xmlresponse);
					$xpath = new DOMXpath($document);
					$xpath->registerNamespace('atom', 'http://www.w3.org/2005/Atom');
					$xpath->registerNamespace('gd', 'http://schemas.google.com/g/2005');
					foreach ($xpath->evaluate('/atom:feed/atom:entry') as $entry) {
						$contact = [
							'FirstName' => $xpath->evaluate('string(atom:title)', $entry),
							'Image' => $xpath->evaluate('string(atom:link[@rel="http://schemas.google.com/contacts/2008/rel#photo"]/@href)', $entry),
							'Email' => [],
							'PhoneNo' => [],
							'Location'=>[],
							'Address' => []
						];
						foreach ($xpath->evaluate('gd:email', $entry) as $email) {
							$contact['Email'][] = $email->getAttribute('address');
						}
						foreach ($xpath->evaluate('gd:phoneNumber', $entry) as $number) {
							$contact['PhoneNo'][] = trim($number->textContent);
						}
						
						foreach ($xpath->evaluate('gd:organization', $entry) as $organ) {
							$contact['Location'][] = trim($organ->textContent);
						}

						foreach ($xpath->evaluate('gd:postalAddress', $entry) as $foraddress) {
							$contact['Address'][] = trim($foraddress->textContent);
						}
						if (!empty($contact['Email']))
							$contact['Email'] = $contact['Email'][0];
						if (!empty($contact['PhoneNo']))
							$contact['PhoneNo'] = $contact['PhoneNo'][0];
						
						if (!empty($contact['Location']))
							$contact['Location'] = $contact['Location'][0];

						if (!empty($contact['Address']))
							$contact['Address'] = $contact['Address'][0];
						  if (empty($contact['Address']))
							  $contact['Address'] = '';
						else
							$contact['PhoneNo'] = '';

						$emailCheck = array();
						$emailCheck['Email'] =  $contact['Email'];
						$emailCheck['UserId'] =  $this->session->userdata('id');
						$leadResult = $this->lead_model->checkLeadEmailExists($emailCheck);
						 if(is_array($contact['Location'])){
									if(empty($contact['Location'])){
										$contact['Location'] = '';
									}
								}
						if(empty($leadResult)){
							
								$leadData = array();
								$leadData['FirstName'] = $contact['FirstName'];
								$leadData['Email'] = $contact['Email'];
								$leadData['PhoneNo'] = $contact['PhoneNo'];
								$leadData['LeadSourceId'] = 1;
								$leadData['LeadStatusId'] = 1;
								$leadData['ClientId'] =  $this->session->userdata('id');
								$leadData['CreatedBy'] =  $this->session->userdata('id');

								$leadData['Location'] = $contact['Location'];
								$this->lead_model->saveLead($leadData);
								$contact['AddSystemOff'] = 1;
						}
						$contact['UserId'] = $this->session->userdata('id');
						$googleResult = $this->lead_model->checkGoogleEmailExists($emailCheck);
						if(empty($googleResult))
						{
							$this->lead_model->saveGmailContact($contact);
						}
            
					}
					redirect('Contact/contactsMerge');
				}
			 

  }
  function curl_file_get_contents($url) {
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);  //The URL to fetch. This can also be set when initializing      a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);   //The number of seconds to wait while trying to connect.
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);  //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);  //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);  //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        //echo $contents;
        curl_close($curl);
        return $contents;
    }
  
}

?>