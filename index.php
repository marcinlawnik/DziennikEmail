<?php
// DziennikEmail

include 'simplehtmldom.php';
$ch = curl_init();
//COOKIES
//Set the path of the cookie file as supplied
$cookiePath = dirname(__FILE__).'/cookies.txt';
//Set the cookie storing files
//Cookie files are necessary since we are logging and session data needs to be saved
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiePath);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiePath);

//CURL properties
//Set the useragent (This one is my laptop)
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.22 (KHTML, like Gecko) Ubuntu Chromium/25.0.1364.160 Chrome/25.0.1364.160 Safari/537.22');
//Specify that we want the content after the query
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//Follow Location redirects
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//Set timeout
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
//Ignore SSL
//curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
//Add SSL certificates
//curl_setopt($ch, CURLOPT_CAINFO, 'cacert.pem');


//Pobierz stronę z tokenem
curl_setopt($ch, CURLOPT_URL, 'https://dziennik.ekos.edu.pl');
//Set referrer
//curl_setopt($ch, CURLOPT_REFERER, 'https://92.55.225.11/dbviewer/login.php');
//Execute
$result = curl_exec($ch);


//GET auth token
$html=str_get_html($result);
//authenticity_token
$token = $html->find('input[name=authenticity_token]');
foreach ($token as $singleToken) {
   $tokenFinal =$singleToken->value;
}
include 'haslo.php';

//Post do zalogowania
$post = 'commit=' . '&authenticity_token=' . $tokenFinal . '&login=' . $username . '&password=' . $password . '&utf8=✓';
//Set the URL
curl_setopt($ch, CURLOPT_URL, 'https://dziennik.ekos.edu.pl/sessions?locale=pl');
//Define that this is a POST query
curl_setopt($ch, CURLOPT_POST, 1);
//Set the post data
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//Execute
curl_exec($ch);

//Żądanie get do ocen
//Go to page with grades
curl_setopt($ch, CURLOPT_URL, 'https://dziennik.ekos.edu.pl/student/semesters/41/grades?locale=pl');
$result = curl_exec($ch);

echo $result;

//wyloguj

curl_setopt($ch, CURLOPT_URL, 'https://dziennik.ekos.edu.pl/log_out?locale=pl');
$result = curl_exec($ch);