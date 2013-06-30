<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// get all categories
$categories = fetchCategories();
$id = 0;
if(isset($_SESSION['rid'])){
	$id  = (isset($_GET['id'])) ? $_GET['id'] : $_SESSION['rid'];
}

?>

<table class="subHeader">
<tr>
<td id="header">
<iframe width="400" height="150" src="/Taurent_Travel/media/admin/scroller_newstic.html" SCROLLING="no" FRAMEBORDER="0" border=0 allowTransparency="true"></iframe>
</td> 
</tr>
</table>

<table cellpadding="3" width="100%" class="navigation" ><tr><td align="center">
<a href="<?php echo $_SERVER['PHP_SELF'] . "?view=detail&id=" . $id ?>"> Home </a></td>
<?php

if(isset($_SESSION['personality'])){

	echo "<td width=\"100%\"><a href=\"" . $_SERVER['PHP_SELF'] . "?view=personalityResult&id=$id\" >Personality</a></td>";

}else{

	if((!isset($_GET['t']))||($_GET['t']=='skill')){
	
	  echo "<td align=\"center\"><a href=\"" . $_SERVER['PHP_SELF'] . "?t=personality&c=0&id=$id\" >Personality</a></td>";
		
	}else if($_GET['t']='personality'){
	
	  echo "<td align=\"center\" id=\"current\"><a href=\"" . $_SERVER['PHP_SELF'] . "?t=personality&c=0&id=$id\">Personality</a></td>";	
	
	}

}	

foreach ($categories as $category) {
	extract($category);
	// now we have $cat_id, $cat_parent_id, $cat_name
	if(isset($_SESSION['skill'.$skill_id])){
		$url   = $_SERVER['PHP_SELF'] . "?view=skillResult&c=$skill_id&id=$id";
	}else{
		$url   = $_SERVER['PHP_SELF'] . "?t=skill&c=$skill_id&id=$id";
	}
	// assign id="current" for the currently selected category
	// this will highlight the category name
	$listId = '';
	if ($skill_id == $skillId) {
		$listId = ' id="current"';
	}
	
?>

<td align="center"<?php echo $listId; ?>><a href="<?php echo $url; ?>" ><?php echo $skill_name; ?></a></td>
<?php
}
?>


<?php
	
	if((isset($_SESSION['rid']))&&(isset($_SESSION['eid']))){
?>
	<td align="center"><a href="index.php?view=logout" >Log Out</td>

<?php		
	
	}

?>
</tr></table>

