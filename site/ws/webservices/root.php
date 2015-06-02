<?php
//base or main class for webservices which has common functions
class root {
	var $entityName = "";

function __construct( $entityName ){
   $this->entityName = $entityName;
}

function returnEmptyRecordJSON ($args, $mesg="No Records Found") {
	$arrResult = array();
	$arrResult['entity'] = $this->entityName;
	$arrResult['method_called'] = array_shift($args);
	$arrResult['method_args'] = $args;
	$arrResult['SANmessage'] = $mesg;
	echo json_encode($arrResult);
}
// method to get all the records in an entity
function  getAllRecords() {
	// query database for existing data
	global $app;
	//echo "getSocialUsers<br>";
    $allRecords = R::findAll($this->entityName);
    
	 $app->response()->header('Content-Type', 'application/json');
    if ($socialProfile) {
      // if found, return JSON response
      echo json_encode(R::exportAll($allRecords));
    } else {
      // else return empty string
      return $this->returnEmptyRecordJSON(array('getAllRecords',''));
    }
}
// method to get the Record with Primary Key id $id from the db
function getRecordWithKeyVal($key, $key_val) {
	// query database for existing data
	global $app;
    $record = R::findAll($this->entityName, "$key=?", array($key_val));
    //echo "getRecordWithKeyVal for entity: $entityName: $key, $key_val<br>\nResult: $record";   

   $app->response()->header('Content-Type', 'application/json');

    if ($record) {
      // if found, return JSON response
      echo json_encode(R::exportAll($record));
    } else {
      // else return empty string
      return $this->returnEmptyRecordJSON(array('getRecordWithKeyVal',$key, $key_val));
    }
}
// method to delete the Social Profile with socialType and id $id from the db
function deleteRecordWithKeyVal($key, $key_val) {
	// query database for existing data
	global $app;
    $records = R::findAll($this->entityName, "$key=?", array($key_val));
	
    $app->response()->header('Content-Type', 'application/json');
	
    if ($records) {
      // if found, return JSON response
      R::trashAll( $records );
	  return $this->returnEmptyRecordJSON(array('deleteRecordWithKeyVal', $key, $key_val), "Deleted Records of key: $key and val: $key_val!!");
    } else {
      // else return empty string
      return $this->returnEmptyRecordJSON(array('deleteRecordWithKeyVal', $key, $key_val));
    }
}

function deleteAllRecords() {
	global $app;
	R::wipe( $this->entityName ); //burns all the books!
	return $this->returnEmptyRecordJSON(array('deleteAllRecords',''), "Deleted All Records!!");
}

} //class ends

?>