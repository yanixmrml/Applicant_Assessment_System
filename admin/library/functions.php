<?php


/*
	Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user
*/
function checkUser()
{

	// if the session id is not set, redirect to login page
	if (!isset($_SESSION['dss_user_id'])) {


		header('Location:  login.php');
		exit;
	}
	
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();
	}
	
}

/*
	
*/
function doLogin()
{
	// if we found an error save the error message in this variable
	$errorMessage = '';
	
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	
	// first, make sure the username & password are not empty
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
		$sql = "SELECT user_id
		        FROM user 
				WHERE user_name = '$userName' AND user_password ='$password'";
		$result = dbQuery($sql);
	
		if (dbNumRows($result) == 1) {
			$row = dbFetchAssoc($result);
			$_SESSION['dss_user_id'] = $row['user_id'];
			$_SESSION['user_name'] = $userName;
		
			
			// log the time when the user last login
			$sql = "UPDATE user 
			        SET user_last_login = NOW() 
					WHERE user_id = '{$row['user_id']}'";
			dbQuery($sql);

			// now that the user is verified we move on to the next page
            // if the user had been in the admin pages before we move to
			// the last page visited
			if ((isset($_SESSION['login_return_url']))&&(strpos($_SESSION['login_return_url'],"login.php")==false)){
				//header('Loskillion: ' . $_SESSION['login_return_url']);
				header('Location: index.php');
				exit;
			} else {
				header('Location: index.php');
				exit;
			}
		} else {
			$errorMessage = 'Wrong username or password';
		}		
			
	}
	
	return $errorMessage;
}

/*
	Logout a user
*/
function doLogout()
{
	if (isset($_SESSION['dss_user_id'])) {
		unset($_SESSION['dss_user_id']);
		session_unregister('dss_user_id');
	}
		
	header('Location: login.php');
	exit;
}


/*
	Generate combo box options containing the skillegories we have.
	if $skillId is set then that skill is selected
*/
function buildSkillOptions($skillId = 0)
{
	$sql = "SELECT skill_id, skill_parent_id, skill_name
			FROM skill
			ORDER BY skill_id";
	$result = dbQuery($sql) or die('Cannot get skills ' . mysql_error());
	
	while($row = dbFetchArray($result)) {
		list($id, $parentId, $name) = $row;
		
		if ($parentId == 0) {
			// we create a new array for each top level skillegories
			$skills[$id] = array('name' => $name, 'children' => array());
		} else {
			// the child skillegories are put int the parent skill's array
			$skills[$parentId]['children'][] = array('id' => $id, 'name' => $name);	
		}
	}	
	
	// build combo box options
	$list = '';
	foreach ($skills as $key => $value) {
		$name     = $value['name'];
		$children = $value['children'];
		
		$list .= "<optgroup label=\"$name\">"; 
		
		foreach ($children as $child) {
			$list .= "<option value=\"{$child['id']}\"";
			if ($child['id'] == $skillId) {
				$list.= " selected";
			}
			
			$list .= ">{$child['name']}</option>\r\n";
		}
		
		$list .= "</optgroup>";
	}
	
	return $list;
}

function buildAllPersonalityOptions($personalityId = 0)
{
	$sql = "SELECT personality_id, personality_parent_id, personality_name
			FROM personality
			ORDER BY personality_id";
	$result = dbQuery($sql) or die('Cannot get personality ' . mysql_error());
	
	while($row = dbFetchArray($result)) {
		list($id, $parentId, $name) = $row;
		
		if ($parentId == 0) {
			// we create a new array for each top level skillegories
			$skills[$id] = array('name' => $name, 'children' => array());
		} else {
			// the child skillegories are put int the parent skill's array
			$skills[$parentId]['children'][] = array('id' => $id, 'name' => $name);	
		}
	}	
	
	// build combo box options
	$list = '';
	foreach ($skills as $key => $value) {
		$name     = $value['name'];
		$children = $value['children'];
		
		$list .= "<optgroup label=\"$name\">"; 
		
		foreach ($children as $child) {
			$list .= "<option value=\"{$child['id']}\"";
			if ($child['id'] == $skillId) {
				$list.= " selected";
			}
			
			$list .= ">{$child['name']}</option>\r\n";
		}
		
		$list .= "</optgroup>";
	}
	
	return $list;
}

function countAllParentPersonality(){
	$sql = "SELECT personality_id, personality_name
			FROM personality
			WHERE personality_parent_id = 0 AND personality_status = 'Activate'
			ORDER BY personality_id";
	$result = dbQuery($sql) or die('Cannot get Personality. ' . mysql_error());
	$num = dbNumRows($result);
	return $num;
}

function buildPersonalityOptions($personalityId = 0)
{
	$sql = "SELECT personality_id, personality_name
			FROM personality
			WHERE personality_parent_id = 0 AND personality_status = 'Activate'
			ORDER BY personality_id";
	$result = dbQuery($sql) or die('Cannot get Personality. ' . mysql_error());
	
	$personality = array();
	while($row = dbFetchArray($result)) {
		list($id, $name) = $row;
	
		// we create a new array for each top level categories
		$personality[$id] = array('name' => $name, 'id' => $id);
		
	}	
	
	// build combo box options
	$list = '';
	foreach ($personality as $key => $value) {
		$name     = $value['name'];
		$id = $value['id'];
		
		$list .= "<option value=\"$id\"";
		if ($id == $personalityId) {
			$list.= " selected";
		}
			
		$list .= ">$name</option>\r\n";
	}
	
	return $list;
}


/*
	Create the paging links
*/
function getPagingNav($sql, $pageNum, $rowsPerPage, $queryString = '')
{
	$result  = mysql_query($sql) or die('Error, query failed. ' . mysql_error());
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$numrows = $row['numrows'];
	
	// how many pages we have when using paging?
	$maxPage = ceil($numrows/$rowsPerPage);
	
	$self = $_SERVER['PHP_SELF'];
	
	// creating 'previous' and 'next' link
	// plus 'first page' and 'last page' link
	
	// print 'previous' link only if we're not
	// on page one
	if ($pageNum > 1)
	{
		$page = $pageNum - 1;
		$prev = " <a href=\"$self?page=$page{$queryString}\">[Prev]</a> ";
	
		$first = " <a href=\"$self?page=1{$queryString}\">[First Page]</a> ";
	}
	else
	{
		$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
		$first = ' [First Page] '; // nor 'first page' link
	}
	
	// print 'next' link only if we're not
	// on the last page
	if ($pageNum < $maxPage)
	{
		$page = $pageNum + 1;
		$next = " <a href=\"$self?page=$page{$queryString}\">[Next]</a> ";
	
		$last = " <a href=\"$self?page=$maxPage{$queryString}{$queryString}\">[Last Page]</a> ";
	}
	else
	{
		$next = ' [Next] ';      // we're on the last page, don't enable 'next' link
		$last = ' [Last Page] '; // nor 'last page' link
	}
	
	// return the page navigation link
	return $first . $prev . " Showing page <strong>$pageNum</strong> of <strong>$maxPage</strong> pages " . $next . $last; 
}


?>