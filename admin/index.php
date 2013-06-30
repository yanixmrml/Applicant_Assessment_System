<?php
require_once '../library/config.php';
require_once './library/functions.php';

checkUser();

$content = 'home.php';

$pageTitle = 'Administrator';
$script = array();
require_once 'include/template.php';
?>
