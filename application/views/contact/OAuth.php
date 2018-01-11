<?php
$client_id='329695175100-gitjf23mbennldjiqit33f588o11grms.apps.googleusercontent.com';
$client_secret='tTx_6xfVUOePSdbm0FWebAwd';
$redirect_uri=base_url().'contact/OAuth';
$max_results = 1000;
$auth_php = $_REQUEST["code"];
function curl_file_get_contents($url)
{
       $curl = curl_init();
       $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
       curl_setopt($curl,CURLOPT_URL,$url);  //The URL to fetch. This can also be set when initializing      a session with curl_init().
       curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
       curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);   //The number of seconds to wait while trying to connect.
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
$fields=array(
'code'=> $auth_php,
'client_id'=> $client_id,
'client_secret'=> $client_secret,
'redirect_uri'=> $redirect_uri,
'grant_type'=> 'authorization_code'
);


$post = '';
foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }

$post = rtrim($post,'&');
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
curl_setopt($curl,CURLOPT_POST,5);
curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,"<strong>TRUE</strong>");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,"<strong>FALSE</strong>");

$result = curl_exec($curl);
curl_close($curl);
$response = json_decode($result);

$accesstoken = $response->access_token;
$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&oauth_token='.$accesstoken;
// $headers = array(
// 'Host: www.google.com',
// 'Gdata-version: 3.0',
// 'Content-length: '.strlen($url),
// 'Content-type: application/atom+xml',
// 'Authorization: OAuth '.$accesstoken
// );

$xmlresponse = curl_file_get_contents($url);

if((strlen(stristr($xmlresponse,'Authorization required'))>0) && (strlen(stristr($xmlresponse,'Error '))>0)) //At times you get Authorization error from Google.
{
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
$contact1=array();
foreach ($xpath->evaluate('/atom:feed/atom:entry') as $entry) {
  $contact = [
    'name' => $xpath->evaluate('string(atom:title)', $entry),
    'image' => $xpath->evaluate('string(atom:link[@rel="http://schemas.google.com/contacts/2008/rel#photo"]/@href)', $entry),
    'emails' => [],
    'numbers' => []
  ];
  foreach ($xpath->evaluate('gd:email', $entry) as $email) {
    $contact['emails'][] = $email->getAttribute('address');
  }
  foreach ($xpath->evaluate('gd:phoneNumber', $entry) as $number) {
    $contact['numbers'][] = trim($number->textContent);
  }
  //var_dump($contact);
  array_push($contact1,$contact);
  
}
//print_r($contact1);
// $xml = new SimpleXMLElement($xmlresponse);

// $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
// $result = $xml->xpath('//gd:phoneNumber');
// echo "<pre>";
// print_r($result);
// foreach ($result as $title) {
//         echo $title->attributes()->address . "<br>";
// }

?>
<table width="100%" border="1">
      <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
      </tr>
      <?php foreach($contact1 as $data):?>
      <tr>
            <td><?php echo $data['name'];?></td>
            <td><?php echo!empty($data['numbers'])?$data['numbers'][0]:"";?></td>
            <td><?php echo!empty($data['emails'])?$data['emails'][0]:"";?></td>
      </tr>      
      <?php endforeach;?>      
</table>
