<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Skill';
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Job Applicant Assessment Systeml - Add Skill';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Modify Skill';
		break;

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Skill';
}


$script    = array('skill.js');

require_once '../include/template.php';
?>
