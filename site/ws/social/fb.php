<?php
require_once 'socialRoot.php';
$facebook = new socialRoot('Facebook');
$facebook->authNAddUser();
?>