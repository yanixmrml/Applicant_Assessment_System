<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'add' :
        addSkill();
        break;
      
    case 'modify' :
        modifySkill();
        break;
        
    case 'delete' :
        deleteSkill();
        break;
	   
    default :
        // if action is not defined or unknown
        // move to main skill page
        header('Location: index.php');
}


/*
    Add a skill
*/
function addSkill()
{
    $name        = $_POST['txtName'];
    $description = $_POST['mtxDescription'];
    $parentId    = $_POST['hidParentId'];
	$status      = $_POST['status'];
	$item        = $_POST['txtItem'];
    
    
    $sql   = "INSERT INTO skill(skill_parent_id, skill_name, skill_description, skill_status, skill_items, skill_date) 
              VALUES ($parentId, '$name', '$description', '$status',$item, NOW())";
    $result = dbQuery($sql) or die('Cannot add skill' . mysql_error());
    
    header('Location: index.php?skillId=' . $parentId);              
}


/*
    Modify a skill
*/
function modifySkill()
{
    $skillId       = (int)$_GET['skillId'];
    $name        = $_POST['txtName'];
    $description = $_POST['mtxDescription'];
	$status      = $_POST['status'];
	$item        = $_POST['txtItem'];
      
    $sql    = "UPDATE skill 
               SET skill_name = '$name', skill_description = '$description', skill_status = '$status', skill_items = $item,
			   skill_last_update = NOW()
               WHERE skill_id = $skillId";
           
    $result = dbQuery($sql) or die('Cannot update skill. ' . mysql_error());
    header('Location: index.php');              
}

/*
    Remove a skill
*/
function deleteSkill()
{
    if (isset($_GET['skillId']) && (int)$_GET['skillId'] > 0) {
        $skillId = (int)$_GET['skillId'];
    } else {
        header('Location: index.php');
    }
    
	// find all the children skillegories
	$children = getChildren($skillId);
	
	// make an array containing this skill and all it's children
	$skills  = array_merge($children, array($skillId));
	$numSkill = count($skills);

    // finally remove the skill from database;
    $sql = "DELETE FROM skill 
            WHERE skill_id IN (" . implode(',', $skills) . ")";
    dbQuery($sql);
    
    header('Location: index.php');
}


/*
	Recursively find all children of $skillId
*/
function getChildren($skillId)
{
    $sql = "SELECT skill_id ".
           "FROM skill ".
           "WHERE skill_parent_id = $skillId ";
    $result = dbQuery($sql);
    
	$skill = array();
	if (dbNumRows($result) > 0) {
		while ($row = dbFetchRow($result)) {
			$skill[] = $row[0];
			// call this function again to find the children
			$skill  = array_merge($skill, getChildren($row[0]));
		}
    }

    return $skill;
}

?>