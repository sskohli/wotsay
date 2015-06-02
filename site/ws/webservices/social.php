<?php
require_once 'root.php';

class social extends root {
	// method to get the Social Profile with socialType and id $id from the db
	function  getAllSocialUsersForType($socialType) {
		// query database for existing data
		return $this->getRecordWithKeyVal('social_type', $socialType);
	}
	
	// method to get the Social Profile with socialType and id $id from the db
	function getSocialUser($socialType, $id) {
		// query database for existing data
		global $app;
		$socialProfile = R::findOne('social', 'social_type=? AND identifier=?', array($socialType, $id));
		//echo "getSocialUser for: $socialType, $id<br>\nResult: $socialProfile";
		if ($socialProfile) {
		  // if found, return JSON response
		  $app->response()->header('Content-Type', 'application/json');
		  echo json_encode(R::exportAll($socialProfile));
		} else {
		  // else return empty string
		  return $this->returnEmptyRecordJSON(array('getSocialUser',$socialType, $id));
		}
	}
	
	// method to create a Social Profile with POST Data
	function createSocialProfile() {
		// get and decode JSON request body
		global $app;
		//echo "CreateUser Called<br>";
		$request = $app->request();
		$body = $request->getBody();
		$input = json_decode($body, true); 
		$DEBUG_LEVEL = 2;
		if ($DEBUG_LEVEL == 2) {
			echo "<pre>";print_r($input); echo "</pre>";
		}
		// store article record
		$userCols = array( 'socialType', 'identifier', 'username', 'profileURL', 'websiteURL', 'photoURL', 'displayName', 'description', 'firstName', 'lastName', 'gender', 'language', 'age',
			'birthDay', 'birthMonth', 'birthYear', 'email', 'emailVerified', 'phone', 'address', 'country', 'region', 'city', 'zip', 'dateAdded');
		$user = R::dispense('social');
		
		foreach ($userCols as $key) {
			$user[$key] = $input[$key];
		}
		$id = R::store($user);    
		//echo "store Called<br>";
		// return JSON-encoded response body
		$app->response()->header('Content-Type', 'application/json');
		echo json_encode(R::exportAll($user));
	}
	
	function  deleteAllSocialUsersForType($socialType) {
		// query database for existing data
		return $this->deleteRecordWithKeyVal('social_type', $socialType);
	}
	
	// method to delete the Social Profile with socialType and id $id from the db
	function deleteSocialUser($socialType, $id) {
		// query database for existing data
		global $app;
		$socialProfile = R::findOne('social', 'socialType=? AND identifier=?', array($socialType, $id));
		
		if ($socialProfile) {
		  // if found, return JSON response
		  R::trash( $socialProfile );
		  echo "Deleted Social records of type: $socialType and id:$id !!";
		} else {
		  // else return empty string
		  echo "";
		}
	}
}
?>