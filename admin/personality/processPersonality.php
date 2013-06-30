<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'add' :
        addPersonality();
        break;
      
    case 'modify' :
        modifyPersonality();
        break;
        
    case 'delete' :
        deletePersonality();
        break;
    
    case 'deleteImage' :
        deleteImage();
        break;
    
	   
    default :
        // if action is not defined or unknown
        // move to main personality page
        header('Location: index.php');
}


/*
    Add a personality
*/
function addPersonality()
{
    $name        = $_POST['txtName'];
    $description = $_POST['mtxDescription'];
    $parentId    = $_POST['hidParentId'];
	$status      = $_POST['status'];
	
	if($parentId==0){
	
    	$pos     = $_POST['txtPositive'];
    	$neg     = $_POST['txtNegative'];
		$sql   = "INSERT INTO personality(personality_parent_id, personality_name, personality_description, personality_status, personality_item_positive,
		          personality_item_negative, personality_date) 
				  VALUES($parentId, '$name', '$description','$status', $pos, $neg , NOW())";
    }else{
		$attitude =   $_POST['factor'];
		$career = $_POST['mtxCareer'];
		$sql   = "INSERT INTO personality(personality_parent_id, personality_name, personality_description, personality_status, personality_career, attitude, 
		          personality_date) 
				  VALUES ($parentId, '$name', '$description', '$status','$career', '$attitude', NOW())";
	}
	$result = dbQuery($sql) or die('Cannot add personality' . mysql_error());
    header('Location: index.php?personalityId=' . $parentId);              
}


/*
    Modify a personality
*/
function modifyPersonality()
{
    $personalityId       = (int)$_GET['personalityId'];
    $parentId    = $_POST['hidParentId'];
    $name        = $_POST['txtName'];
    $description = $_POST['mtxDescription'];
	$status      = $_POST['status'];
	if(isset($_POST['txtItem'])){
		$item    = (int)$_POST['txtItem'];
    }else{
		$item    = 0;
	}
		
	if($parentId==0){
	
    	$pos       = $_POST['txtPositive'];
    	$neg       = $_POST['txtNegative'];
		$sql    = "UPDATE personality 
               SET personality_name = '$name', personality_description = '$description', personality_status = '$status', personality_item_positive = $pos,
			   personality_item_negative = $neg, personality_last_update = NOW()
               WHERE personality_id = $personalityId";
    }else{
		$attitude =   $_POST['factor'];
		$career = $_POST['mtxCareer'];
		$sql    = "UPDATE personality 
               SET personality_name = '$name', personality_description = '$description', personality_status = '$status', personality_career = '$career',
			   attitude = '$attitude', personality_last_update = NOW()
               WHERE personality_id = $personalityId";
	} 
	       
    $result = dbQuery($sql) or die('Cannot update personality. ' . mysql_error());
    header('Location: index.php');              
}

/*
    Remove a personality
*/
function deletePersonality()
{
    if (isset($_GET['personalityId']) && (int)$_GET['personalityId'] > 0) {
        $personalityId = (int)$_GET['personalityId'];
    } else {
        header('Location: index.php');
    }
    
	
	// find all the children personality
	$children = getChildren($personalityId);
	
	// make an array containing this personality and all it's children
	$personalitys  = array_merge($children, array($personalityId));
	$numPersonality = count($personalitys);

    // finally remove the personality from database;
    $sql = "DELETE FROM personality 
            WHERE personality_id IN (" . implode(',', $personalitys) . ")";
    dbQuery($sql);
    
	$searchQuestionId = "SELECT test_id FROM personality_test WHERE personality_id = $personalityId";
	$res =  dbQuery($searchQuestionId);
	if(dbNumRows($res)>0){
		extract(dbFetchAssoc($res));
		$deleteChoices = "DELETE FROM test_choices WHERE test_id = " . $test_id;
		dbQuery($deleteChoices);
	}
	
	$deleteTests = "DELETE FROM personality_test WHERE personality_id = " . $personalityId;
	dbQuery($deleteTests);

    header('Location: index.php');
}


/*
	Recursively find all children of $personalityId
*/
function getChildren($personalityId)
{
    $sql = "SELECT personality_id ".
           "FROM personality ".
           "WHERE personality_parent_id = $personalityId ";
    $result = dbQuery($sql);
    
	$personality = array();
	if (dbNumRows($result) > 0) {
		while ($row = dbFetchRow($result)) {
			$personality[] = $row[0];
			// call this function again to find the children
			$personality  = array_merge($personality, getChildren($row[0]));
		}
    }

    return $personality;
}

?>