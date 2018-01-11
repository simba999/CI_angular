<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH . 'PHPMailer/PHPMailerAutoload.php';
require FCPATH . 'PHPMailer/class.phpmailer.php';

class Message extends MY_Controller {

    public $_table_header = 'message_header';
    public $_table_message = 'message';
    public $_table_user = 'users';
    public $_table_googleCred = 'googlecred';
    public $gmailClient = '';
    public $refreshToken = '';
    
    public function __construct() {
        parent::__construct();

        $this->load->model('message_model');
        $this->load->model('lead_model');
        require FCPATH . 'vendor/autoload.php';
        define('SCOPES', implode(' ', array(
                'https://www.google.com/m8/feeds/',
            Google_Service_Gmail::GMAIL_READONLY,
            Google_Service_Gmail::GMAIL_COMPOSE,
            Google_Service_Gmail::GMAIL_LABELS,
            Google_Service_Gmail::GMAIL_SEND,
            Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
            Google_Service_Gmail::GMAIL_SETTINGS_SHARING,
            Google_Service_Gmail::GMAIL_INSERT
            )
        ));
        
            
    }

    public function index() {
        $this->load->view('components/htmlheader');
        $this->load->view('components/header');
        $this->load->view('components/sidebar');
        $this->load->view('message/index');
    }

    public function create() {
        $loginId=$this->session->userdata('id');
        $where['type']=1;
        $where['userId']=$loginId;
        $refreshTokenExe = $this->crud->selectOne($this->_table_googleCred,$where);
        $this->refreshToken = $refreshTokenExe['refreshToken'];
        
        $this->gmailClient = new Google_Client();
        $this->gmailClient->setClientId(CLIENT_ID);
        $this->gmailClient->setClientSecret(CLIENT_SECRET_ID);     
        $this->gmailClient->setScopes(SCOPES);
        $this->gmailClient->setAccessType('offline');
        $this->gmailClient->setApprovalPrompt('force');
        $this->gmailClient->setRedirectUri(site_url().'message/create/');
        $service = new Google_Service_Tasks($this->gmailClient);

        $this->gmailClient->refreshToken($this->refreshToken);     
         $gmailService = new Google_Service_Gmail($this->gmailClient);
        $data = json_decode(file_get_contents('php://input'), true);
        $optParam = array();
        if($data['parentId']!=0){
            $referenceId = '';
            $thread = $gmailService->users_threads->get("me", $data['parentId']);
            $optParam['threadId'] = $data['parentId'];
            $threadMessages = $thread->getMessages($optParam);
            $messageId = $threadMessages[0]->getId();
//            $messageDetails = $thread->getMessageDetails($messageId);
//            $messageDetails = $messageDetails['data'];
//            $subject = $messageDetails['headers']['Subject'];
        }
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";

        foreach($data['toUser'] as $email)
            $mail->addAddress($email);
        
        $mail->msgHTML($data['content']);
        $mail->Subject = $data['subject'];
        $mail->preSend();
        $mime = $mail->getSentMIMEMessage();
       
        $mime_data = base64_encode($mime);
        $mime_data = str_replace(array('+','/','='),array('-','_',''),$mime_data); // url safe
       
        $message = new Google_Service_Gmail_Message($this->gmailClient);
        $message->setRaw($mime_data);
        if($data['parentId']!=0)
            $message->setThreadId($data['parentId']);
        
        try {
            $message = $gmailService->users_messages->send('me',$message);
            echo json_encode( array("status" =>1,"data" =>$message->getId(), "message" =>'success'));
        } catch (Exception $e) {
            echo json_encode(array("status" => 0, "data" => '', "message" => $e->getMessage()));
        }        
    }

    public function inbox() {
        $loginId=$this->session->userdata('id');
        $where['type']=1;
        $where['userId']=$loginId;
        $refreshTokenExe = $this->crud->selectOne($this->_table_googleCred,$where);
        $this->refreshToken = $refreshTokenExe['refreshToken'];
        
        $this->gmailClient = new Google_Client();
        $this->gmailClient->setClientId(CLIENT_ID);
        $this->gmailClient->setClientSecret(CLIENT_SECRET_ID);     
        $this->gmailClient->setScopes(SCOPES);
        $this->gmailClient->setAccessType('offline');
        $this->gmailClient->setApprovalPrompt('force');
        $this->gmailClient->setRedirectUri(site_url().'message/inbox/');
        $service = new Google_Service_Tasks($this->gmailClient);
        $this->gmailClient->addScope(Google_Service_Tasks::TASKS);
        $this->gmailClient->refreshToken($this->refreshToken);

            $response = $this->lead_model->getLeadUser('gmail');
            
//            if(!empty($response[0]->Email)) :
            $emails="to:".str_replace(',', '|to:', $response[0]->Email);
            $accessTokenArray = array();
            $accessTokenArray = $this->refreshToken;
            $messages = array(); $pageToken = NULL;$opt_param = array();
            $gmailService = new Google_Service_Gmail($this->gmailClient);
//            do {
//                try {
//                  if ($pageToken) {
                    $opt_param['q']=$emails;  
//                    $opt_param['pageToken'] = $pageToken;
//                  }
                $draftsResponse = $gmailService->users_drafts->listUsersDrafts('me',array("q"=>$opt_param));
                  if ($draftsResponse->getDrafts()) {
                    $messages = array_merge($messages, $draftsResponse->getDrafts());
                    $pageToken = $draftsResponse->getNextPageToken();
                  }
//                } catch (Exception $e) {
//                  print 'An error occurred: ' . $e->getMessage();
//                }
//            } while ($pageToken);
            $draft=count($messages);
            
            $emails="label:sent to:".str_replace(',', '|to:', $response[0]->Email);
            $accessTokenArray = array();
            $accessTokenArray = $this->refreshToken;
            $messages = array(); $pageToken = NULL;$opt_param = array();
            $gmailService = new Google_Service_Gmail($this->gmailClient);
//            do {
//                try {
//                  if ($pageToken) {
                    $opt_param['q']=$emails;  
//                    $opt_param['pageToken'] = $pageToken;
//                  }
                  $messagesResponse = $gmailService->users_messages->listUsersMessages('me',$opt_param);
                  if ($messagesResponse->getMessages()) {
                    $messages = array_merge($messages, $messagesResponse->getMessages());
                    $pageToken = $messagesResponse->getNextPageToken();
                  }
//                } catch (Exception $e) {
//                  print 'An error occurred: ' . $e->getMessage();
//                }
//            } while ($pageToken);
            $sent=count($messages);
            
            $emails="from:".str_replace(',', '|from:', $response[0]->Email);
           // $emails="from:vidhyag@itpathsolutions.in";
            $accessTokenArray = array();
            $accessTokenArray = $this->refreshToken;
            $messages = array(); $pageToken = NULL;$opt_param = array();
            $gmailService = new Google_Service_Gmail($this->gmailClient);

//            if ($messagesResponse->getMessages()) {
//                $messages = array_merge($messages, $messagesResponse->getMessages());
//            }
//            do {
//                try {
//                  if ($pageToken) {
                    $opt_param['q']=$emails;  
//                    $opt_param['pageToken'] = $pageToken;
//                  }
                  $messagesResponse = $gmailService->users_messages->listUsersMessages('me',$opt_param);
                  if ($messagesResponse->getMessages()) {
                    $messages = array_merge($messages, $messagesResponse->getMessages());
                    $pageToken = $messagesResponse->getNextPageToken();
                  }
//                } catch (Exception $e) {
//                  print 'An error occurred: ' . $e->getMessage();
//                }
//            } while ($pageToken);
            $inbox=array();
            $inbox['totalInbox']=count($messages);
            $inbox['totalSent']=$sent;
            $inbox['totalDraft']=$draft;
            $inbox['inboxMessages']=array();
            foreach ($messages as $message) {
                $temp=array(); $content="";$files=array();$attachlink="";
                $temp['threadId']=$message->getThreadId();
                $message = $gmailService->users_messages->get('me', $message->getId(),array('format'=>'full'));
                /** test start***/
                $payload = $message->getPayload();
                $parts = $payload->getParts();
                // With no attachment, the payload might be directly in the body, encoded.
                $body = $payload->getBody();
                $FOUND_BODY = FALSE;
                // If we didn't find a body, let's look for the parts
                if(!$FOUND_BODY) {
                    foreach ($parts  as $part) {
                        if($part['parts'] && !$FOUND_BODY) {
                            foreach ($part['parts'] as $p) {
                                if($p['parts'] && count($p['parts']) > 0){
                                    foreach ($p['parts'] as $y) {
                                        if(($y['mimeType'] === 'text/html') && $y['body']) {
                                            $FOUND_BODY = $this->decodeBody($y['body']->data);
                                            break;
                                        }
                                    }
                                } else if(($p['mimeType'] === 'text/html') && $p['body']) {
                                    $FOUND_BODY = $this->decodeBody($p['body']->data);
                                    break;
                                }
                            }
                        }
                        if($FOUND_BODY) {
                            break;
                        }
                    }
                }
                // let's save all the images linked to the mail's body:
                if($FOUND_BODY && count($parts) > 1){
                    $images_linked = array();
                    foreach ($parts  as $part) {
                        if($part['filename']){
                            array_push($images_linked, $part);
                            $attachmentData= $gmailService->users_messages_attachments->get('me', $message->getId(), $part['body']->attachmentId);
                            array_push($files,array($part['filename']=>$this->decodeBody(utf8_encode($attachmentData->data)))); 
                            $attachlink.="<a href=''>$part[filename]</a>";
                        } else{
                            if($part['parts']) {
                                foreach ($part['parts'] as $p) {
                                    if($p['parts'] && count($p['parts']) > 0){
                                        foreach ($p['parts'] as $y) {
                                            if(($y['mimeType'] === 'text/html') && $y['body']) {
                                                array_push($images_linked, $y);
                                            }
                                        }
                                    } else if(($p['mimeType'] !== 'text/html') && $p['body']) {
                                        array_push($images_linked, $p);
                                    }
                                }
                            }
                        }
                    }
                    // special case for the wdcid...
                    preg_match_all('/wdcid(.*)"/Uims', $FOUND_BODY, $wdmatches);
                    if(count($wdmatches)) {
                        $z = 0;
                        foreach($wdmatches[0] as $match) {
                            $z++;
                            if($z > 9){
                                $FOUND_BODY = str_replace($match, 'image0' . $z . '@', $FOUND_BODY);
                            } else {
                                $FOUND_BODY = str_replace($match, 'image00' . $z . '@', $FOUND_BODY);
                            }
                        }
                    }
                    preg_match_all('/src="cid:(.*)"/Uims', $FOUND_BODY, $matches);
                    if(count($matches)) {
                        $search = array();
                        $replace = array();
                        // let's trasnform the CIDs as base64 attachements 
                        foreach($matches[1] as $match) {
                            foreach($images_linked as $img_linked) {
                                foreach($img_linked['headers'] as $img_lnk) {
                                    
                                    if( $img_lnk['name'] === 'Content-ID' || $img_lnk['name'] === 'Content-Id' || $img_lnk['name'] === 'X-Attachment-Id'){
                                        if ($match === str_replace('>', '', str_replace('<', '', $img_lnk->value)) 
                                                || explode("@", $match)[0] === explode(".", $img_linked->filename)[0]
                                                || explode("@", $match)[0] === $img_linked->filename){
                                            $search = "src=\"cid:$match\"";
                                            $mimetype = $img_linked->mimeType;
                                            $attachment = $gmailService->users_messages_attachments->get('me', $message->getId(), $img_linked['body']->attachmentId);
                                            $data64 = strtr($attachment->getData(), array('-' => '+', '_' => '/'));
                                            $replace = "src=\"data:" . $mimetype . ";base64," . $data64 . "\"";
                                            $FOUND_BODY = str_replace($search, $replace, $FOUND_BODY);                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // If we didn't find the body in the last parts, 
                // let's loop for the first parts (text-html only)
                if(!$FOUND_BODY) {
                    foreach ($parts  as $part) {
                        if($part['body'] && $part['mimeType'] === 'text/html') {
                            $FOUND_BODY = $this->decodeBody($part['body']->data);
                            break;
                        }
                    }
                }
                // With no attachment, the payload might be directly in the body, encoded.
                if(!$FOUND_BODY) {
                    $FOUND_BODY = $this->decodeBody($body['data']);
                }
                // Last try: if we didn't find the body in the last parts, 
                // let's loop for the first parts (text-plain only)
                if(!$FOUND_BODY) {
                    foreach ($parts  as $part) {
                        if($part['body']) {
                            $FOUND_BODY = $this->decodeBody($part['body']->data);
                            break;
                        }
                    }
                }
                if(!$FOUND_BODY) {
                    $FOUND_BODY = '(No message)';
                }
                // Finally, print the message ID and the body
                // print_r($message->getId() . ": " . $FOUND_BODY);
                $content=$FOUND_BODY;                
                /** end test ******/
//                $parts = $message['payload']->getParts();
//                foreach($parts as $part)
//                {
//                   // print_r($part);
//                    if(isset($part['parts']))
//                    {
//                        foreach($part['parts'] as $subpart)
//                        {
//                     //       $content =base64_decode(strtr($subpart['body']->data,'-_', '+/'));
//                        }
//                    }
//                    elseif($part['mimeType']==='text/html')
//                    {  
//                   //     $content =base64_decode(strtr($part['body']->data,'-_', '+/'));
//                  //      break;                    
//                    }      
//                    if(!empty($part['filename']))
//                    {
//                        $attachmentData= $gmailService->users_messages_attachments->get('me', $message->getId(), $part['body']->attachmentId);
//                        //echo base64_decode(strtr($attachmentData->data,'-_', '+/'));
//                        array_push($files,$part['filename']); 
//                    }
//
//                }
                $headers=$message['payload']->headers;
                $temp['Id']=$message['id'];
                
                foreach($headers as $header){
                    if($header['name']=='From')
                    {
                        //echo $header['value'];
                        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $header['value'], $matches);
                        $lead=$this->lead_model->getLeadUser(array('Email'=>$matches[0][0]));
                        $temp['From']=$matches[0][0];
                        $pattern = "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
                        $replacement = "";
                        $header['value']=preg_replace($pattern, $replacement, $header['value']);
                        $temp['FirstName']=preg_replace("/<>/", $replacement, $header['value']);
                        $temp['LastName']="";
//                        $temp['FirstName']=substr($header['value'], 0, strpos($header['value'],' '));
//                        $temp['LastName']=substr($header['value'], strpos($header['value'],' ')+1,strpos($header['value'],' ')+1);                        
                        
                        //$temp['Id']=$lead[0]->Id;
                        if(!empty($lead[0]->LeadImage))
                            $temp['ProfileImage']=$lead[0]->LeadImage;
                        else
                            $temp['ProfileImage']='';
                    }    
                    if($header['name']=='Subject')
                        $temp['Subject']=$header['value'];                        
                    if($header['name']=='Date')
                    {
                        $temp['CreatedOn']=date('M d, Y',strtotime($header['value'])); 
                        $temp['sentTime']=date('g:i:s A',strtotime($header['value'])); 
                        $temp['sentTimeInHour']=date('H:i A',strtotime($header['value'])); 
                    }                       
                }
                $temp['Content']=$content;//$message['snippet'];
                $temp['ReadMessage']='0';
                $temp['ReplyMessage']='0';
                array_push($inbox['inboxMessages'],$temp);
            }
            echo json_encode($inbox);   
//        else:
//            echo json_encode(array('totalInbox'=>0,'totalSent'=>0,'totalDraft'=>0,'inboxMessages'=>array()));   
//        endif;
//        $parameters = array('*','DATE_FORMAT(message.createdOn,"%l:%i %p") AS sentTime');
//        $join[] = array(
//            'jointable' => $this->_table_user . ' AS sender ',
//            'joinon' => "sender.Id = header.FromId",
//            'jointype' => "inner");
//		$join[] = array(
//            'jointable' => $this->_table_message . ' AS message ',
//            'joinon' => "header.MessageContentId = message.Id",
//            'jointype' => "inner");
//
//        $condition = array(
//            'header.ToId' => $this->session->userdata('id'),
//            'header.ToDeleted' => 0,
//            'header.Status' => 'sent'
//        );
//        $inboxMessages = $this->crud->selectJoin("$this->_table_header AS header", $condition, $join, $parameters);
//		//MessageContentId
//              //  print_r($inboxMessages); exit;
       //echo json_encode($inboxMessages);
    }

    public function sentbox() {
        $loginId=$this->session->userdata('id');
        $where['type']=1;
        $where['userId']=$loginId;
        $refreshTokenExe = $this->crud->selectOne($this->_table_googleCred,$where);
        $this->refreshToken = $refreshTokenExe['refreshToken'];
        
        $this->gmailClient = new Google_Client();
        $this->gmailClient->setClientId(CLIENT_ID);
        $this->gmailClient->setClientSecret(CLIENT_SECRET_ID);     
        $this->gmailClient->setScopes(SCOPES);
        $this->gmailClient->setAccessType('offline');
        $this->gmailClient->setApprovalPrompt('force');
        $this->gmailClient->setRedirectUri(site_url().'message/inbox/');
        $service = new Google_Service_Tasks($this->gmailClient);
        $this->gmailClient->addScope(Google_Service_Tasks::TASKS);
        $this->gmailClient->refreshToken($this->refreshToken);

            $response = $this->lead_model->getLeadUser('gmail');
            if(!empty($response[0]->Email)) :
            $emails="label:sent to:".str_replace(',', '|to:', $response[0]->Email);
            $accessTokenArray = array();
            $accessTokenArray = $this->refreshToken;
            $messages = array();
            $gmailService = new Google_Service_Gmail($this->gmailClient);

            $messagesResponse = $gmailService->users_messages->listUsersMessages('me',array("q"=>$emails,"labelIds"=>["SENT"]));

            if ($messagesResponse->getMessages()) {
                $messages = array_merge($messages, $messagesResponse->getMessages());
            }
            
            $inbox=array();
            foreach ($messages as $message) {
                $temp=array();
                $message = $gmailService->users_messages->get('me', $message->getId());
                $headers=$message['payload']->headers;
                $temp['Id']=$message['id'];
                foreach($headers as $header){
                    if($header['name']=='To')
                    {
                        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $header['value'], $matches);
                        $lead=$this->lead_model->getLeadUser(array('Email'=>$matches[0][0]));
//                        $temp['From']=$matches[0][0];
            //            $temp['Id']=$lead[0]->Id;
                        $pattern = "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
                        $replacement = "";
                        $header['value']=preg_replace($pattern, $replacement, $header['value']);
                        $temp['RecFirNam']=preg_replace("/<>/", $replacement, $header['value']);
                        $temp['RecLasNam']="";
//                        $temp['RecFirNam']=substr($header['value'], 0, strpos($header['value'],' '));
//                        $temp['RecLasNam']=substr($header['value'], strpos($header['value'],' ')+1,strpos($header['value'],' ')+1);
//                        $temp['RecFirNam']=$lead[0]->FirstName;
//                        $temp['RecLasNam']=$lead[0]->LastName;
                        if(!empty($lead[0]->LeadImage))
                            $temp['RecProfImg']=$lead[0]->LeadImage;
                        else
                            $temp['RecProfImg']='';
                    }    
                    if($header['name']=='Subject')
                        $temp['Subject']=!empty($header['value'])?$header['value']:"No Subject";                        
                    if($header['name']=='Date')
                    {
                        $temp['CreatedOn']=date('Y-m-d H:i:s',strtotime($header['value'])); 
                        $temp['sentTime']=date('H:i:s',strtotime($header['value'])); 
                    }                       
                }
                $temp['Content']=$message['snippet'];
                $temp['ReadMessage']='0';
                $temp['ReplyMessage']='0';
              //  $temp['rowId']=$i;
                array_push($inbox,$temp);
        //        $i++;
               // array_push($inbox,$temp);
            }
        echo json_encode($inbox);  
        else:
            echo json_encode(array('totalInbox'=>0,'totalSent'=>0,'totalDraft'=>0,'inboxMessages'=>array()));   
        endif;
        /*$parameter = array('sender.Id AS senderId','sender.ProfileImage','sender.FirstName','sender.LastName','message.Id As msgId','message.Content','message.Subject','header.Id AS msgHdrId');*/
//        $parameter = array('DATE_FORMAT(message.createdOn,"%l:%i %p") AS sentTime','header.CreatedOn','sender.Id AS senderId','sender.ProfileImage','sender.FirstName','sender.LastName','message.*','header.Id AS msgHdrId','receiver.Id AS recId','receiver.ProfileImage as RecProfImg','receiver.FirstName As RecFirNam','receiver.LastName As RecLasNam');
//
//        $join[] = array(
//            'jointable' => $this->_table_user . ' AS sender ',
//            'joinon' => "sender.Id = header.FromId",
//            'jointype' => "inner");
//         $join[] = array(
//            'jointable' => $this->_table_user . ' AS receiver ',
//            'joinon' => "receiver.Id = header.ToId",
//            'jointype' => "inner");
//		$join[] = array(
//            'jointable' => $this->_table_message . ' AS message ',
//            'joinon' => "header.MessageContentId = message.Id",
//            'jointype' => "inner");
//        $condition = array(
//            'header.FromId' => $this->session->userdata('id'),
//            'header.ToDeleted' => 0,
//            'header.Status' => 'sent'
//        );
//        $sentMessages = $this->crud->selectJoin("$this->_table_header AS header", $condition, $join, $parameter);
        /*echo $this->db->last_query();
        exit;*/

 //       echo json_encode($sentMessages);
    }
    
    public function darftbox() {
        $loginId=$this->session->userdata('id');
        $where['type']=1;
        $where['userId']=$loginId;
        $refreshTokenExe = $this->crud->selectOne($this->_table_googleCred,$where);
        $this->refreshToken = $refreshTokenExe['refreshToken'];
        
        $this->gmailClient = new Google_Client();
        $this->gmailClient->setClientId(CLIENT_ID);
        $this->gmailClient->setClientSecret(CLIENT_SECRET_ID);     
        $this->gmailClient->setScopes(SCOPES);
        $this->gmailClient->setAccessType('offline');
        $this->gmailClient->setApprovalPrompt('force');
        $this->gmailClient->setRedirectUri(site_url().'message/inbox/');
        $service = new Google_Service_Tasks($this->gmailClient);
        $this->gmailClient->addScope(Google_Service_Tasks::TASKS);
        $this->gmailClient->refreshToken($this->refreshToken);
         $gmailService = new Google_Service_Gmail($this->gmailClient);
         
            $response = $this->lead_model->getLeadUser('gmail');
            if(!empty($response[0]->Email)) :
            $emails="To:".str_replace(',', '|To:', $response[0]->Email);
            //$emails="in:draft";
            $accessTokenArray = array();
            $accessTokenArray = $this->refreshToken;
            $drafts = array();

            try {
              $draftsResponse = $gmailService->users_drafts->listUsersDrafts('me',array("q"=>$emails));
              if ($draftsResponse->getDrafts()) {
                $drafts = array_merge($drafts, $draftsResponse->getDrafts());
              }
            } catch (Exception $e) {
              print 'An error occurred: ' . $e->getMessage();
            }
            $inbox=array();
            //$i=1;
            foreach ($drafts as $draft) {
                //print 'Draft with ID: ' . $draft->getId() . '<br/>';
                $draft_msg = $gmailService->users_drafts->get('me', $draft->getId());
                $message = $draft_msg->getMessage();
                //print_r($message);  
                $temp=array();
                $headers=$message['payload']->headers;
                $temp['Id']=$message['id'];
                foreach($headers as $header){
                    if($header['name']=='To')
                    {
                        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $header['value'], $matches);
                        $lead=$this->lead_model->getLeadUser(array('Email'=>$matches[0][0]));
//                        $temp['From']=$matches[0][0];
                        //$temp['Id']=$lead[0]->Id;
                         $pattern = "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
                        $replacement = "";
                        $header['value']=preg_replace($pattern, $replacement, $header['value']);
                        $temp['FirstName']=preg_replace("/<>/", $replacement, $header['value']);
                        $temp['LastName']="";
//                        $temp['FirstName']=substr($header['value'], 0, strpos($header['value'],' '));
//                        $temp['LastName']=substr($header['value'], strpos($header['value'],' ')+1,strpos($header['value'],' ')+1);
//                        $temp['FirstName']=$lead[0]->FirstName;
//                        $temp['LastName']=$lead[0]->LastName;
                        if(!empty($lead[0]->LeadImage))
                            $temp['ProfileImage']=$lead[0]->LeadImage;
                        else
                            $temp['ProfileImage']='';
                    }    
                    if($header['name']=='Subject')
                        $temp['Subject']=!empty($header['value'])?$header['value']:"No Subject";                        
                    if($header['name']=='Date')
                    {
                        $temp['CreatedOn']=date('Y-m-d H:i:s',strtotime($header['value'])); 
                        $temp['sentTime']=date('H:i:s',strtotime($header['value'])); 
                    }                       
                }
                $temp['Content']=$message['snippet'];
                $temp['ReadMessage']='0';
                $temp['ReplyMessage']='0';
               // $temp['rowId']=$i;
                array_push($inbox,$temp);
               // $i++;
            }
            echo json_encode($inbox);      
             else:
            echo json_encode(array('totalInbox'=>0,'totalSent'=>0,'totalDraft'=>0,'inboxMessages'=>array()));   
        endif;
//        $parameter = array('header.CreatedOn','sender.Id AS senderId','sender.ProfileImage','sender.FirstName','sender.LastName','message.*','header.Id AS msgHdrId','receiver.Id AS recId','receiver.ProfileImage as RecProfImg','receiver.FirstName As RecFirNam','receiver.LastName As RecLasNam');
//
//        $join[] = array(
//            'jointable' => $this->_table_user . ' AS sender ',
//            'joinon' => "sender.Id = header.FromId",
//            'jointype' => "inner");
//        $join[] = array(
//            'jointable' => $this->_table_user . ' AS receiver ',
//            'joinon' => "receiver.Id = header.ToId",
//            'jointype' => "inner");
//        $join[] = array(
//            'jointable' => $this->_table_message . ' AS message ',
//            'joinon' => "header.MessageContentId = message.Id",
//            'jointype' => "inner");
//
//
//        $condition = array(
//            'header.FromId' => $this->session->userdata('id'),
//            'header.ToDeleted' => 0,
//            'header.Status' => 'draft'
////            'header.Status' => 'schedule'
//        );
//        $draftMessages = $this->crud->selectJoin("$this->_table_header AS header", $condition, $join,$parameter);
//
//        echo json_encode($draftMessages);
    }
    
    public function readStatus() {
        $where = $_GET;
        $readStatus;
        if($where['ReadMessage']==0)
            $readStatus=1;
        else
            $readStatus=0;
        $messageHeader = array(
                'ReadMessage' => $readStatus,
                'UpdatedBy' => $this->session->userdata('id')
        );
        $response = $this->message_model->updateReadStatus($messageHeader,$where);
        echo json_encode($response);
    }
    public function replyStatus(){
        $where['Id']=$parentId;
        $replyHeader = array(
                'ReplyMessage' => 1,
                'UpdatedBy' => $this->session->userdata('id')
        );
       
        $response = $this->message_model->updateReadStatus($replyHeader,$where);
        echo json_encode($response);
    }
    public function gmailsyncDB($loginId = ''){
        if(!empty($loginId)){
            $refreshTokenQuery = "SELECT `refreshToken` FROM $this->_table_googleCred WEHRE type =1 AND userId = '{$loginId}'";
            $refreshTokenExe = $this->crud->selectOne($refreshTokenQuery);
            $this->refreshToken = $refreshTokenExe['refreshToken'];
        }
    }
    function decodeBody($body) {
        $rawData = $body;
        $sanitizedData = strtr($rawData,'-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if(!$decodedMessage){
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }
}