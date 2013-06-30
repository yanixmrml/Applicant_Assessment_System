<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Question';
		break;

	case 'add' :
		$content 	= 'add.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Add Question';
		break;

	case 'modify' :
		$content 	= 'modify.php';		
		$pageTitle 	= 'Job Applicant Assessment System - Modify Question';
		break;

	case 'detail' :
		$content    = 'detail.php';
		$pageTitle  = 'Job Applicant Assessment System - View Question Detail';
		break;
		
	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View Question';
}




$script    = array('skill_question.js');

require_once '../include/template.php';
?>
