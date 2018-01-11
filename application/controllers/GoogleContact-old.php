<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleContact extends CI_Controller {

    public function __construct() {
        parent :: __construct();
        $this->load->helper('url');
        $this->config->load('mail_config');
        $this->load->model('Wedding_team_modal');
        $this->load->model('Checklist_modal');
        $this->load->model('User_modal');
        $this->load->model('Vendor_modal');
        $this->load->model('Package_modal');
        $this->load->database();
    }

    public function index() {

        $user_id = $this->session->userdata('front_uid');
        $client_id = '329695175100-gitjf23mbennldjiqit33f588o11grms.apps.googleusercontent.com';
        $client_secret = 'tTx_6xfVUOePSdbm0FWebAwd';
        $redirect_uri = 'http://localhost/agentcloudcrm/application/views/contact/OAuth.php';
        $max_results = 1000;
        $auth_php = $_REQUEST["code"];

        $fields = array(
            'code' => $auth_php,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        );


        $post = '';
        foreach ($fields as $key => $value) {
            $post .= $key . '=' . $value . '&';
        }

        $post = rtrim($post, '&');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, 5);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $result = curl_exec($curl);
        $jsonData = rtrim($result, "\0");
        $response = json_decode($jsonData);
       
        $accesstoken = $response->access_token;
        $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&oauth_token=' . $accesstoken;

        $xmlresponse = $this->curl_file_get_contents($url);

        if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) { //At times you get Authorization error from Google.
            echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
            exit();
        }
        echo "<h3>Contact Details:</h3>";
        //echo "<pre>";
        $document = new DOMDocument();
        $document->loadXml($xmlresponse);
        $xpath = new DOMXpath($document);
        $xpath->registerNamespace('atom', 'http://www.w3.org/2005/Atom');
        $xpath->registerNamespace('gd', 'http://schemas.google.com/g/2005');
        $contact1 = array();
        foreach ($xpath->evaluate('/atom:feed/atom:entry') as $entry) {
            $contact = [
                'contact_name' => $xpath->evaluate('string(atom:title)', $entry),
                'profile_img' => $xpath->evaluate('string(atom:link[@rel="http://schemas.google.com/contacts/2008/rel#photo"]/@href)', $entry),
                'contact_email' => [],
                'contact_no' => []
            ];
            foreach ($xpath->evaluate('gd:email', $entry) as $email) {
                $contact['contact_email'][] = $email->getAttribute('address');
            }
            foreach ($xpath->evaluate('gd:phoneNumber', $entry) as $number) {
                $contact['contact_no'][] = trim($number->textContent);
            }
            //var_dump($contact);
            if (!empty($contact['contact_email']))
                $contact['contact_email'] = $contact['contact_email'][0];
            if (!empty($contact['contact_no']))
                $contact['contact_no'] = $contact['contact_no'][0];
            else
                $contact['contact_no'] = '';
            array_push($contact1, $contact);
        }
        
        $this->session->set_userdata('google_contacts',$contact1);
        redirect(base_url().'front/wedding_team'); 
        
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
//    public function importContact() {
//        $user_id = $this->session->userdata('front_uid');
//        $filename = $_FILES["file"]["tmp_name"];
//        if ($_FILES["file"]["size"] > 0) {
//            $file = fopen($filename, "r");
//            $i = 0;
//            while (($contactData = fgetcsv($file, 10000, ",")) !== FALSE) {
//                if ($i != 0) {
//                    $data1 = array(
//                        'user_id' => $user_id,
//                        'contact_name' => $contactData[0],
//                        'contact_no' => $contactData[1],
//                        'contact_email' => $contactData[2],
//                    );
//                    $insertId = $this->Wedding_team_modal->insertCSV($data1);
//                }
//                $i++;
//            }
//            fclose($file);
//            if ($insertId) {
//                $data['showContacts'] = $this->Wedding_team_modal->getContacts(array('user_id' => $this->session->userdata('front_uid')));
//                $this->load->view('frontend/user/weddingteam', $data);
//            } else {
//                $data['error'] = 'Error while importing CSV.';
//                $this->load->view('frontend/user/weddingteam', $data);
//            }
//        } else {
//            $data['error'] = 'Could not be read.';
//            $this->load->view('frontend/user/weddingteam', $data);
//        }
//    }

}
