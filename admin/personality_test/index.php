<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Test';
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Add Test';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Modify Test';
		break;

	case 'detail' :
		$content    = 'detail.php';
		$pageTitle  = 'Job Applicant Assessment System - View Test Detail';
		break;
		
	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Test';
}




$script    = array('personality_test.js');

require_once '../include/template.php';
?>
