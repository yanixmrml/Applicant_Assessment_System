<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if(!isset($_SESSION['rid'])){
	header("Location: /" . WEB_ROOT . "index.php");
	exit;
}else if((isset($_GET['view'])) && ($_GET['view'] != "skillResult") && (!isset($_GET['skillId'])) && (!isset($_GET['id'])) && ($_SESSION['rid']!=$_GET['id'])){
	header("Location: /" . WEB_ROOT . "index.php?view=detail&id=".$_SESSION['rid']);
	exit;
}else{
	$record_id = $_SESSION['rid'];
	$skillId = $_GET['c'];
}

	$errorMessage = '&nbsp;';

	$getResult = "SELECT  r.record_score, r.record_items, s.skill_name FROM skill_record r, skill s WHERE r.record_id = $record_id AND r.skill_id = $skillId 
	AND r.skill_id = s.skill_id";
	$res = dbQuery($getResult);
	extract(dbFetchAssoc($res));

?>

<br/>
<table class="orangeBackground" ><tr><td align="center">
			CONFIRMATION : Congratualtions! You finished take the test.
			The information below are your results from the skill's test.
</td></tr></table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>		
<table width="600" class="division" align="center" cellpadding="5"><tr><td width="100%" align="center" class="subhead">
     <?php echo strtoupper($skill_name) . " RESULT"; ?>
</td></tr>
<tr><td>


	<table width="570" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
    <tr> <td align="center" width="150" class="entryTableHeader"> Results </td>
	</tr>
	<tr>
    <td width="150" class="label">TOTAL ITEMS</td>
    <td class="content"><?php echo $record_items ?></td>
    </tr>
	<tr>
    <td width="150" class="label">TOTAL SCORE</td>
    <td class="content"> <?php echo $record_score ?></td>
    </tr>
	<tr>
    <td width="150" class="label">PERCENTAGE</td>
    <td class="content"><?php echo (($record_score/$record_items)*100) . "%" ?></td>
    </tr>
	</table>
	</td>
<tr/></table>