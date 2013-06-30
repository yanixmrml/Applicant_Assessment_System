<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Users';
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Add Users';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Modify Users';
		break;

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Users';
}

$script    = array('user.js');

require_once '../include/template.php';
?>
