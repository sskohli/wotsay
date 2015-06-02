<?php
    require "common.php";
    $pathToConfig = getcwd() ."/hybridauth/hybridauth/config.php";
    require_once( getcwd() ."/hybridauth/hybridauth/Hybrid/Auth.php" );
 
    $hybridauth = new Hybrid_Auth( $pathToConfig );
 
    $adapter = $hybridauth->authenticate( "Facebook" );
 
    $user_profile = $adapter->getUserProfile();
	
	$user_json = json_encode($user_profile);	
	
	$user_profile = json_decode($user_json, true);
	
	$user_profile['socialType'] = "Facebook";

	$user_json = json_encode($user_profile);
	
	//First check if this user already added to the db
	$identifier = $user_profile['identifier'];
    //echo "<pre>";print_r($user_profile); echo "</pre>";
	$socialProfile = callAPI("GET", "http://wotsays.com/s.php/social/Facebook/$identifier");
    
	$arrSocial = json_decode($socialProfile, true);
	//echo "<pre>";print_r($arrSocial); echo "</pre>";
	//if not present add user
	if (array_key_exists("SANmessage", $arrSocial)) {
		//echo "<pre> " . $user_json.  " </pre>";
		$result = callAPI("POST", "http://wotsays.com/s.php/social/", $user_json);
	
		echo "<pre>";print_r($result); echo "</pre>";
	} else {
		echo "User already created!!<br><pre>";print_r($socialProfile); echo "</pre>";
	}

?>