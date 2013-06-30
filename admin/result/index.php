<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
		
		case "individual":	$content 	= 'viewIndividualResult.php';		
							$pageTitle 	= 'Job Applicant Assessment System - View Individual Result'; 
							 break;		
		default :
		$content 	= 'viewAllApplicants.php';		
		$pageTitle 	= 'Job Applicant Assessment System - View All Applicants';
}


$script    = array('common.js');

require_once '../include/template.php';
?>
