<?php
require_once 'socialRoot.php';
$twitter = new socialRoot('Twitter');
$twitter->authNAddUser();
?>