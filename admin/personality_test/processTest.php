<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	
	case 'addTest' :
		addTest();
		break;
		
	case 'modifyTest' :
		modifyTest();
		break;
		
	case 'deleteTest' :
		deleteTest();
		break;
    

	default :
	    // if action is not defined or unknown
		// move to main test page
		header('Location: index.php');
}


function addTest()
{
    
	$personalityId     = $_POST['cboPersonality'];
	$test    = $_POST['mtxTest'];
	$factor       = $_POST['factor'];
	
	$sql   = "INSERT INTO personality_test (personality_id, test_item, test_factor, test_date)
				  VALUES ($personalityId, '$test', '$factor' , NOW())";		  
	$result = dbQuery($sql);
	
	$searchNewId = "SELECT test_id FROM personality_test WHERE test_item = '$test' AND test_factor = '$factor'";
	$result2 = dbQuery($searchNewId);
	extract(dbFetchAssoc($result2));
	
	$findChocies = " SELECT choice_id FROM choice ORDER BY choice_id";
	$result3 = dbQuery($findChocies);
	
	if($factor=='Positive'){
		while($row = dbFetchAssoc($result3)){
			extract($row);
			$insert = "INSERT INTO test_choices(choice_id,test_id,value) VALUES($choice_id,$test_id,6-$choice_id)"; 
			$result4 = dbQuery($insert);
		} 
	}else{
		while($row = dbFetchAssoc($result3)){
			extract($row);
			$insert = "INSERT INTO test_choices(choice_id,test_id,value) VALUES($choice_id,$test_id,$choice_id)"; 
			$result4 = dbQuery($insert);
		} 
	}
	
	header("Location: index.php?personalityId=$personalityId");	
}


/*
	Modify a test
*/
function modifyTest()
{
	$testId   =       (int)$_GET['testId'];	
    $personalityId  = $_POST['cboPersonality'];
	$test    = $_POST['mtxTest'];
	$factor      = $_POST['factor'];
	
	$sql = "UPDATE personality_test SET test_item = '$test', test_factor = '$factor ', test_last_update = NOW(), 
	test_last_update = NOW() WHERE test_id = $testId";
	$result  = dbQuery($sql);	
		
	$findChocies = " SELECT choice_id  FROM choice ORDER BY choice_id";
	$result3 = dbQuery($findChocies);
	
	if($factor=='Positive'){
		while($row = dbFetchAssoc($result3)){
			extract($row);
			$insert = "UPDATE test_choices SET value = 6-$choice_id WHERE test_id = $testId AND choice_id = $choice_id "; 
			$result4 = dbQuery($insert);
		} 
	}else{
		while($row = dbFetchAssoc($result3)){
			extract($row);
			$insert = "UPDATE test_choices SET  value = $choice_id WHERE test_id = $testId AND choice_id = $choice_id "; 
			$result4 = dbQuery($insert);
		} 
	}	
	
	header("Location: index.php?personalityId=$personalityId");		  
}

/*
	Remove a test
*/
function deleteTest()
{
	if (isset($_GET['testId']) && (int)$_GET['testId'] > 0) {
		$testId = (int)$_GET['testId'];
	} else {
		header('Location: index.php');
	}
	
	// remove any references to this test from
	// tbl_order_item and tbl_cart
	$sql = "DELETE FROM test_choices
	        WHERE test_id = $testId";
	dbQuery($sql);
			
	
	// remove the test from database;
	$sql = "DELETE FROM personality_test 
	        WHERE test_id = $testId";
	dbQuery($sql);
	
	header('Location: index.php?personalityId=' . $_GET['personalityId']);
}

?>