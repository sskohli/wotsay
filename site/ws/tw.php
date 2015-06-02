<?php
    
    $pathToConfig = "/home/sskohli/public_html/wotsays.com/hybridauth-master/hybridauth/config.php";
    require_once( "/home/sskohli/public_html/wotsays.com/hybridauth-master/hybridauth/Hybrid/Auth.php" );
 
    $hybridauth = new Hybrid_Auth( $pathToConfig );
 
    $adapter = $hybridauth->authenticate( "Twitter" );
 
    $user_profile = $adapter->getUserProfile();

    print_r($user_profile);

?>