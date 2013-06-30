<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// set the default page title
$pageTitle = 'Applicant Assessment System';

// if a product id is set add the product name
// to the page title but if the product id is not
// present check if a category id exist in the query string
// and add the category name to the page title

if (isset($_GET['t'])&&isset($_GET['c']) && (int)$_GET['c'] > 0) {
	
	$type  =  $_GET['c']; 
	$catId = (int)$_GET['c'];
	if($type=="p"){
		$pageTitle = "Personality";
	}else{
		$sql = "SELECT skill_name
	        FROM skill
			WHERE skill_id = $catId";
		$result    = dbQuery($sql);
		$row       = dbFetchAssoc($result);
		$pageTitle = $row['skill_name'];	
	}		
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="include/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="library/common.js"></script>
<script language="JavaScript" type="text/javascript" src="library/profile.js"></script>
</head>
<body>