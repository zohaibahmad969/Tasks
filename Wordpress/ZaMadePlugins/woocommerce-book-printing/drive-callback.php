<?php
if (isset($_GET['code'])) {
	require plugin_dir_path(__FILE__) . 'vendor/autoload.php';
	
	$client = new Google_Client();

	$client->setApplicationName('Characterful Personalised Story Books');

	$client->setRedirectUri(plugin_dir_url( __FILE__ ) . 'drive-callback.php');

	$client->setScopes(Google_Service_Drive::DRIVE);
	$client->setAuthConfig(plugin_dir_path(__FILE__) . 'credentials.json');
	$client->setAccessType('offline');
	$client->setPrompt('select_account consent');
	$client->setIncludeGrantedScopes(true);
	
	$tokenPath = plugin_dir_path(__FILE__) . 'token.json';

	// Load previously authorized token from a file, if it exists.
	// The file token.json stores the user's access and refresh tokens, and is
	// created automatically when the authorization flow completes for the first
	// time.
	$accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($accessToken);

	// Check to see if there was an error.
	if (array_key_exists('error', $accessToken)) {
	throw new Exception(join(', ', $accessToken));
	}
	
    // Save the token to a file.
    if (!file_exists(dirname($tokenPath))) {
      mkdir(dirname($tokenPath), 0700, true);
    }
    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
	echo "Token saved";
}