<?php
function get_plugin_dir() {
	return preg_replace('/\\' . DIRECTORY_SEPARATOR . 'plugin-organizer\\' . DIRECTORY_SEPARATOR . 'lib$/', '', dirname(dirname(__FILE__)));
}
function shortcode_gcalendar() {
	$urlset =  get_plugin_dir() . "/" . plugin_basename(dirname($mainFile));
	if(is_user_logged_in()){
		require_once($urlset."tpl/gcalendar.php");
	}
}
function getClient($authCode) {
	$client = new Google_Client();
	$client->setApplicationName(APPLICATION_NAME);
	$client->setScopes(SCOPES);
	$client->setAuthConfig(CLIENT_SECRET_PATH);
	$client->setAccessType('offline');
	$client->setApprovalPrompt('force');
	$credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
	if (file_exists($credentialsPath)) {
		$accessToken = json_decode(file_get_contents($credentialsPath), true);
		$client->setAccessToken($accessToken);
	} else {
		$authUrl = $client->createAuthUrl();
		if($authCode != ''){
			$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
			if(!file_exists(dirname($credentialsPath))){
			  mkdir(dirname($credentialsPath), 0700, true);
			}
			file_put_contents($credentialsPath, json_encode($accessToken));
		}else{
			$print = '<form action="" method="get">';
			$print .= 'Enter verification code:'; 
			$print .= '<input type="text" name="code"> <br><input type="submit" name="submitauth" value="Submit"> <br><br><br>';
			$print .= '</form>';
			$print .= 'Get your code here: <a href="'.$authUrl.'" target="_blank">Click here</a> <br><br><br><br>';
			echo $print;
		}
	}
	if($client->getRefreshToken() != '' ){
		if ($client->isAccessTokenExpired()) {
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());		
			file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
		}
	}else{
	 
	}
	return $client;
}
function expandHomeDirectory($path) {
	$homeDirectory = getenv('HOME');
	if (empty($homeDirectory)) {
		$homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
	}
	return str_replace('~', realpath($homeDirectory), $path);
}
function info_request_ajax(){
    if ( isset($_REQUEST) ) {
		$urlset =  get_plugin_dir() . "/" . plugin_basename(dirname($mainFile));	
		require_once($urlset."tpl/info.php");
    }
   die();
}
function add_new_calendar(){
	if ( isset($_REQUEST) ) {
		$urlset =  get_plugin_dir() . "/" . plugin_basename(dirname($mainFile));
		require_once($urlset."tpl/new.php");
    }
	die();
}
function include_js_files() {
	$url = plugin_dir_url(dirname(__FILE__));
    $script = '
<script src="'.$url.'assets/libs/fullcalendar/fullcalendar.min.js"></script>
';
	echo  $script;
}
function add_css_files() {
	$url = plugin_dir_url(dirname(__FILE__));
    $output = '
<link href="'.$url.'assets/libs/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />

<link href="'.$url.'assets/css/style.css" rel="stylesheet" type="text/css" />';
    echo $output;
}
function wpse_enqueue_datepicker() {
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_register_style( 'jquery-ui', 'http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );  
}