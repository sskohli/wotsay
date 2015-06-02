<?php
require "../common.php";
$pathToConfig = getcwd() ."/../hybridauth/hybridauth/config.php";
require_once( getcwd() ."/../hybridauth/hybridauth/Hybrid/Auth.php" );
//base or main class for all social network interaction
class socialRoot {
	var $socialNetworkName = "";

	function __construct( $socialNetworkName ){
	   $this->socialNetworkName = $socialNetworkName;
	}
	
	function authNAddUser() {
		try {
			global $pathToConfig;
			$hybridauth = new Hybrid_Auth( $pathToConfig );
		 
			$adapter = $hybridauth->authenticate( $this->socialNetworkName );
		 
			$user_profile = $adapter->getUserProfile();
			
			$user_json = json_encode($user_profile);	
			
			$user_profile = json_decode($user_json, true);
			
			$user_profile['socialType'] = $this->socialNetworkName;
		
			$user_json = json_encode($user_profile);
			
			//First check if this user already added to the db
			$identifier = $user_profile['identifier'];
			//echo "<pre>";print_r($user_profile); echo "</pre>";
			$socialProfile = callAPI("GET", "http://wotsays.com/s.php/social/".$this->socialNetworkName. "/$identifier");
			
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
		} catch (Exception $e) {
    		echo 'Caught exception: ',  $e->getMessage(), " pathToConfig: $pathToConfig\n";
		}
	} //function authNAddUser ends
} //class ends
?>